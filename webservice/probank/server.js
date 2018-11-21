var express = require("express");
var app = express();
var mysql = require('mysql');

var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "probank"
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Database Connected!");
});

app.listen(3000, () => {
 console.log("Server running on port 3000");
});

app.get("/validate", function(req, res, next){
  if (req.query.no){
    sql = "select * from nasabah where nomor = \'" + req.query.no + "\'";
    con.query(sql, function(err,result) {
      if (err) throw err;
      if result[0] {
        res.send("Validate")
      } else {
        res.send("Number doesn't exist")
      }
    });
  }else{
    res.send("Hah?");
  }
});

app.get("/transfer", function(req,res,next){
  if (req.query.send && req.query.rcv && req.query.amount && req.query.time) {
    sendsql = "select * from nasabah where nomor = \'" + req.query.send + "\'";
    rcvsql = "select * from nasabah where nomor = \'" + req.query.rcv + "\'";
    con.query(sendsql, function(err,sender) {
      if (err) throw err;
      con.query(rcvsql, function(err,rcvr) {
        if (err) throw err;
        if (sender[0]["saldo"] > req.query.amount) {
          res.send("Transaksi Berhasil");
        } else {
          res.send("Transaksi Gagal : Saldo Tidak Mencukupi");
        }
      });
    });
  } else {
    res.send("Fuck You");
  }
});
