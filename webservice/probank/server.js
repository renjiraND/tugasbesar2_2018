let express = require("express");
let app = express();
let mysql = require('mysql');
let bodyParser = require('body-parser');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({
    extended: true
}));

var cors = require('cors')

app.use(express.urlencoded());


let con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "probank",
  multipleStatements: true
});

app.use(cors())

con.connect(function(err) {
  if (err) throw err;
  console.log("Database Connected!");
});

app.listen(4000, () => {
 console.log("Server running on port 4000");
});

app.get("/validate", function(req, res, next){
  if (req.query.no){
    sql = "select * from nasabah where nomor = \'" + req.query.no + "\'";
    con.query(sql, function(err,result) {
      if (err) throw err;
      if (result[0]) {
        message = {"validation":1, "message":"Nasabah with number " + req.query.no + " exist"}
      } else {
        message = {"validation":0, "message":"Nasabah with number " + req.query.no + " does not exist"}
      }
      res.send(message)
    });
  }else{
    message = {"validation":0, "message":"Request Error"}
    res.send(message)
  }
});

app.post("/transfer", function(req,res,next){
  console.log(req.body);
  if (req.body.send && req.body.rcv && req.body.amount && req.body.time) {
    sendsql = "select * from nasabah where nomor = \'" + req.body.send + "\'";
    rcvsql = "select * from nasabah where nomor = \'" + req.body.rcv + "\'";
    console.log(req.body.time)
    con.query(sendsql, function(err,sender) {
      if (err) throw err;
      if (!sender[0]) {
        message = {"status": 0, "message" : "Sender number does not exist"};
        res.send(message);
        return;
      }
      con.query(rcvsql, function(err,rcvr) {
        if (err) throw err;
        if (!rcvr[0]) {
          message = {"status": 0, "message" : "Receiver number does not exist"}
          res.send(message)
          return
        }
        if (sender[0]["saldo"] > req.body.amount) {
          new_sender_amount = sender[0]["saldo"] - req.body.amount;
          new_rcvr_amount = rcvr[0]["saldo"] + Number(req.body.amount);
          transfersql = `UPDATE nasabah SET saldo=${new_sender_amount} where nomor=${req.body.send};
                        UPDATE nasabah SET saldo=${new_rcvr_amount} where nomor=${req.body.rcv};
                        INSERT INTO transaksi VALUES ('${req.body.send}', '${req.body.rcv}', '${req.body.amount}', '${req.body.time}')`
          console.log(transfersql)
          con.query(transfersql, function(err, result, field) {
            if (err) throw err;
            message = {"status":1, "message" : "Transfer Berhasil"}
            res.send(message)
          })
        } else {
          message = {"status":0, "message" : "Saldo tidak Mencukupi"}
          res.send(message);
        }
      });
    });
  } else {
    message = {"status":0, "message":"Request Error"}
    res.send(message);
  }
});
