package bookservice;


import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.xml.ws.Endpoint;

import java.net.*;
import java.io.*;
import java.sql.*;
import java.util.Iterator;

@WebService(targetNamespace = "http://test")
public class BookService {

  public String APIkey = "AIzaSyCozd0JbgrBxT32kZILK2gKfh7wSKKVOf4";

  public static void main(String[] argv) {
    Object implementor = new BookService ();
    String address = "http://localhost:9000/BookService";
    Endpoint.publish(address, implementor);
  }

  @WebMethod
  public String searchBook(String keyword) throws IOException,ParseException {
    System.out.println("1");
    URL url = new URL("https://www.googleapis.com/books/v1/volumes?q="+keyword+"&key="+APIkey);
    HttpURLConnection con = (HttpURLConnection) url.openConnection();
    System.out.println("2");
    con.setRequestMethod("GET");
    con.setRequestProperty("Content-Type", "application/json");
    con.setConnectTimeout(5000);
    con.setReadTimeout(5000);
    int status = con.getResponseCode();

    BufferedReader in = new BufferedReader(
            new InputStreamReader(con.getInputStream()));
    String inputLine;

    StringBuffer content = new StringBuffer();
    while ((inputLine = in.readLine()) != null) {
      content.append(inputLine);
    }
    in.close();
    System.out.println(content);
    con.disconnect();

    String JSONstring;

    JSONParser jsonParse = new JSONParser();
    JSONstring = content.toString();

    JSONObject JSONBooks = (JSONObject) jsonParse.parse(JSONstring);


//    for (int i = 0; i < ; i++) {
//      JSONObject object = (JSONObject) JSONBooks.get(i);
//      System.out.println(object);
//    }
    System.out.println(JSONBooks.get("totalItems"));
    return JSONstring;
  }



  @WebMethod
  public String getRecommendation(String[] categories) throws IOException, ParseException {
    System.out.println("NTOD");

    String url = "jdbc:mysql://localhost:3306/bookservice";
    String username = "root";
    String password = "";
    String category = categories[0];
    System.out.println("Connecting database...");

    try (Connection connection = DriverManager.getConnection(url, username, password)) {
      System.out.println("Database connected!");

      Statement stmt = null;
      ResultSet rs = null;

      try {

        stmt = connection.createStatement();
        String query = String.format("SELECT id FROM transaksi WHERE amount = (SELECT MAX(amount) FROM transaksi where categories='%s') LIMIT 1", category);
        rs = stmt.executeQuery(query);
        if(rs.first()) {
          System.out.println(rs.getString("id"));
          return rs.getString("id");
        } else {
          URL reccomendurl = new URL("https://www.googleapis.com/books/v1/volumes?q=+subject="+category+"&key="+APIkey);
          HttpURLConnection connect = (HttpURLConnection) reccomendurl.openConnection();
          connect.setRequestMethod("GET");
          connect.setRequestProperty("Content-Type", "application/json");
          connect.setConnectTimeout(5000);
          connect.setReadTimeout(5000);
          int status = connect.getResponseCode();

          BufferedReader in = new BufferedReader(
                  new InputStreamReader(connect.getInputStream()));
          String inputLine;

          StringBuffer content = new StringBuffer();
          while ((inputLine = in.readLine()) != null) {
            content.append(inputLine);
          }
          in.close();
          //System.out.println(content);
          connect.disconnect();

          String JSONstring;

          JSONParser jsonParse = new JSONParser();
          JSONstring = content.toString();

          JSONObject JSONBooks = (JSONObject) jsonParse.parse(JSONstring);
          JSONArray booklist = (JSONArray) JSONBooks.get("items");

          Iterator<JSONObject> iterator = booklist.iterator();
          while (iterator.hasNext()) {
            JSONObject currentbook = iterator.next();
            String x = currentbook.toString();
            String y = String.format("\"categories\":[\"%s\"]", category);
            if (x.contains(y)) {
              return (String)currentbook.get("id");
            }
          }
        }
      }
      catch (SQLException ex){
        // handle any errors
        System.out.println("SQLException: " + ex.getMessage());
        System.out.println("SQLState: " + ex.getSQLState());
        System.out.println("VendorError: " + ex.getErrorCode());
      }
      finally {
        // it is a good idea to release
        // resources in a finally{} block
        // in reverse-order of their creation
        // if they are no-longer needed

        if (rs != null) {
          try {
            rs.close();
          } catch (SQLException sqlEx) { } // ignore

          rs = null;
        }

        if (stmt != null) {
          try {
            stmt.close();
          } catch (SQLException sqlEx) { } // ignore

          stmt = null;
        }
      }
    } catch (SQLException e) {
      throw new IllegalStateException("Cannot connect the database!", e);
    }
    return "";
  }
}
