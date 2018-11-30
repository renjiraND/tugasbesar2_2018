package bookservice;

import com.google.gson.Gson;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.xml.ws.Endpoint;
import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.StandardCharsets;
import java.sql.*;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;
import java.util.List;

@WebService(targetNamespace = "http://test")
public class BookService {

  private String APIkey = "AIzaSyCozd0JbgrBxT32kZILK2gKfh7wSKKVOf4";

  public static void main(String[] argv) {
    Object implementor = new BookService();
    String address = "http://localhost:9000/BookService";
    Endpoint.publish(address, implementor);
  }

  @WebMethod
  public List<Book> searchBook(String keyword) throws IOException, ParseException {
    URL url = new URL("https://www.googleapis.com/books/v1/volumes?q=" + keyword + "&key=" + APIkey);
    StringBuffer content = connectHttpUrlGET(url);
    System.out.println(content);
    String JSONstring;

    JSONParser jsonParse = new JSONParser();
    JSONstring = content.toString();

    JSONObject JSONBooks = (JSONObject) jsonParse.parse(JSONstring);

    JSONArray items = (JSONArray) JSONBooks.get("items");
    List<Book> book_list = new ArrayList<>();


    for (Object o : items) {
      JSONObject book = (JSONObject) o;
      JSONObject volume_info = (JSONObject) book.get("volumeInfo");
      //Get Book ID
      String id = (String) book.get("id");

      //Get Book Title
      String title = (String) volume_info.get("title");

      //Get Authors
      JSONArray authors = (JSONArray) volume_info.get("authors");
      String author;
      if (authors == null) {
        author = "Unknown";
      } else {
        author = (String) authors.get(0);
      }

      //Get Descriptions
      String description;
      if (volume_info.get("description") == null) {
        description = "No Description";
      } else {
        description = (String) volume_info.get("description");
      }

      //GetImageLinks
      JSONObject imageLinks = (JSONObject) volume_info.get("imageLinks");
      String thumbnail;
      if (imageLinks == null) {
        thumbnail = "default";
      } else {
        thumbnail = (String) imageLinks.get("thumbnail");
      }
      //Get Category
      List<String> category_list = new ArrayList<>();
      JSONArray categories = (JSONArray) volume_info.get("categories");
      if (categories == null) {
        category_list.add("None");
      } else {
        for (Object c : categories) {
          category_list.add((String) c);
        }
      }

      //Get Price
      String database_url = "jdbc:mysql://localhost:3306/bookservice";
      String username = "root";
      String password = "";
      int price = -1;
      System.out.println("Connecting database...");

      try (Connection connection = DriverManager.getConnection(database_url, username, password)) {
        System.out.println("Database connected!");

        Statement stmt = null;
        ResultSet rs = null;

        try {
          stmt = connection.createStatement();
          String query = String.format("SELECT * FROM buku WHERE (id = '%s')", id);
          rs = stmt.executeQuery(query);
          if(rs.first()) {
            price = rs.getInt("price");
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
        e.printStackTrace();
        throw new IllegalStateException("Cannot connect the database!", e);
      }


      Book b = new Book(id, title, author, description, thumbnail, category_list, price);
      book_list.add(b);
    }


    Gson gson = new Gson();
    String JSON_result = gson.toJson(book_list);
    System.out.println(JSON_result);
    return book_list;
  }

  @WebMethod
  public Book getBook(String id) throws IOException, ParseException {
        URL url = new URL("https://www.googleapis.com/books/v1/volumes/" + id + "?key=" + APIkey);
        StringBuffer content = connectHttpUrlGET(url);

        String JSONstring;

        JSONParser jsonParse = new JSONParser();
        JSONstring = content.toString();

        JSONObject book = (JSONObject) jsonParse.parse(JSONstring);

        JSONObject volume_info = (JSONObject) book.get("volumeInfo");

        //Get Book Title
        String title = (String) volume_info.get("title");

        //Get Authors
        JSONArray authors = (JSONArray) volume_info.get("authors");
        String author;
        if (authors == null) {
            author = "Unknown";
        } else {
            author = (String) authors.get(0);
        }

        //Get Descriptions
        String description;
        if (volume_info.get("description") == null) {
            description = "No Description";
        } else {
            description = (String) volume_info.get("description");
        }

        //GetImageLinks
        JSONObject imageLinks = (JSONObject) volume_info.get("imageLinks");
        String thumbnail;
        if (imageLinks == null) {
            thumbnail = "default";
        } else {
            thumbnail = (String) imageLinks.get("thumbnail");
        }
        //Get Category
        List<String> category_list = new ArrayList<>();
        JSONArray categories = (JSONArray) volume_info.get("categories");
        if (categories == null) {
            category_list.add("None");
        } else {
            for (Object c : categories) {
                category_list.add((String) c);
            }
        }

        //Get Price
        String database_url = "jdbc:mysql://localhost:3306/bookservice";
        String username = "root";
        String password = "";
        int price = -1;
        System.out.println("Connecting database...");

        try (Connection connection = DriverManager.getConnection(database_url, username, password)) {
            System.out.println("Database connected!");

            Statement stmt = null;
            ResultSet rs = null;

            try {
                stmt = connection.createStatement();
                String query = String.format("SELECT * FROM buku WHERE (id = '%s')", id);
                rs = stmt.executeQuery(query);
                if(rs.first()) {
                    price = rs.getInt("price");
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
            e.printStackTrace();
            throw new IllegalStateException("Cannot connect the database!", e);
        }


        Book b = new Book(id, title, author, description, thumbnail, category_list, price);

        Gson gson = new Gson();
        String JSON_result = gson.toJson(b);
        System.out.println(JSON_result);
        return b;
    }

  @WebMethod
  public long buyBookByID(String BookID, String UserID, String[] categories, String squantity) throws IOException,ParseException {
    System.out.println("BOOKID:"+BookID+"\nUSERID:"+UserID+"\nCATEGS:");
    for (String categ : categories){
      System.out.println(categ);
    }
    //Init required variables
    int quantity = Integer.parseInt(squantity);
    SimpleDateFormat dateFormatter = new SimpleDateFormat("yyyy-MM-dd%20HH:mm:ss");
    Date date = new Date();
    String varTime = dateFormatter.format(date);
    StringBuffer content = new StringBuffer();
    String BankID = "000011112222";
    long status;

    //Init variables for DB connection
    String url = "jdbc:mysql://localhost:3306/bookservice";
    String username = "root";
    String password = "";
    System.out.println("Connecting database...");

    try (Connection connection = DriverManager.getConnection(url, username, password)) {
      System.out.println("Database connected!");
      Statement stmt = null;
      ResultSet rs = null;
      int ur;

      try {
        String varAmount = new String();
        stmt = connection.createStatement();
        String query = String.format("SELECT buku.id, amount, price FROM buku JOIN transaksi on buku.id = transaksi.id AND buku.id = \'"+BookID+"\'");
        rs = stmt.executeQuery(query);
        if(rs.first()) {
          int total = Integer.parseInt(rs.getString("price"));
          varAmount = Integer.toString(total);
          String urlParams = "send=" + UserID + "&rcv=" + BankID + "&amount=" + varAmount + "&time=" + varTime;

          byte[] postData = urlParams.getBytes(StandardCharsets.UTF_8);
          String request = "http://localhost:4000/transfer";

          status = connectHttpUrlPOST(request,postData);

          query = String.format("UPDATE transaksi SET amount = amount + 1 WHERE id = \'"+BookID+"\'");
          ur = stmt.executeUpdate(query);
        } else {
          query = String.format("SELECT price FROM buku WHERE buku.id = \'"+BookID+"\'");
          rs = stmt.executeQuery(query);
          if (rs.next()){
            int total = Integer.parseInt(rs.getString("price"));
            varAmount = Integer.toString(total);
          }
          String urlParams = "send=" + UserID + "&rcv=" + BankID + "&amount=" + varAmount + "&time=" + varTime;

          byte[] postData = urlParams.getBytes(StandardCharsets.UTF_8);
          String request = "http://localhost:4000/transfer";

          status = connectHttpUrlPOST(request,postData);
          for (String category : categories){
            query = String.format("INSERT INTO `transaksi` (`id`, `categories`, `amount`) VALUES (\'"+BookID+"\', \'"+category+"\', '1')");
            ur = stmt.executeUpdate(query);
          }
        }
      }
      catch (SQLException ex){
        System.out.println("SQLException: " + ex.getMessage());
        System.out.println("SQLState: " + ex.getSQLState());
        System.out.println("VendorError: " + ex.getErrorCode());
        return 0;
      }
      finally {

        if (rs != null) {
          try {
            rs.close();
          } catch (SQLException sqlEx) { }
          rs = null;
        }
        if (stmt != null) {
          try {
            stmt.close();
          } catch (SQLException sqlEx) { }
          stmt = null;
        }
      }
    } catch (SQLException e) {
      throw new IllegalStateException("Cannot connect the database!", e);
    }

    return status;
  }

  private StringBuffer connectHttpUrlGET(URL url) throws IOException{
    HttpURLConnection con = (HttpURLConnection) url.openConnection();
    con.setRequestMethod("GET");
    con.setRequestProperty("Content-Type", "application/json");
    con.setConnectTimeout(5000);
    con.setReadTimeout(5000);
    StringBuffer content = getConnectionResponse(con);
    System.out.println(content);
    con.disconnect();
    return content;
  }

  private long connectHttpUrlPOST(String request ,byte[] postData) throws IOException,ParseException{
    int postDataLength = postData.length;
    URL url = new URL(request);
    HttpURLConnection con = (HttpURLConnection) url.openConnection();
    con.setDoOutput(true);
    con.setInstanceFollowRedirects(false);
    con.setRequestMethod("POST");
    con.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");
    con.setRequestProperty("charset", "utf-8");
    con.setRequestProperty("Content-Length", Integer.toString(postDataLength));
    con.setUseCaches(false);
    try (DataOutputStream wr = new DataOutputStream(con.getOutputStream())) {
      wr.write(postData);
    }
    StringBuffer response = getConnectionResponse(con);
    con.disconnect();

    JSONParser jsonParse = new JSONParser();
    String JSONstring = response.toString();
    JSONObject JSONObj = (JSONObject) jsonParse.parse(JSONstring);
    long status = (long)JSONObj.get("status");
    return status;
  }

  private StringBuffer getConnectionResponse(HttpURLConnection con) throws IOException{
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
    return content;
  }


  @WebMethod
  public String getRecommendation(String[] categories) throws IOException, ParseException {

    String url = "jdbc:mysql://localhost:3306/bookservice";
    String username = "root";
    String password = "";
    String category = categories[0];
    System.out.println("Connecting database...");

    String encoded_category = new String(category);
      System.out.println(category);
      System.out.println(encoded_category);
    category = java.net.URLDecoder.decode(category, "UTF-8");
    System.out.println(category);
    System.out.println(encoded_category);
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
          URL recommend_url = new URL("https://www.googleapis.com/books/v1/volumes?q=+subject="+encoded_category+"&key="+APIkey);
          System.out.println();
          System.out.println(recommend_url);
          StringBuffer content = connectHttpUrlGET(recommend_url);

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
            System.out.println(x);
            System.out.println(y);
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
      e.printStackTrace();
      throw new IllegalStateException("Cannot connect the database!", e);
    }
    return "NoRecommendation";
  }
}
