package bookservice;


import com.google.gson.Gson;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.JSONValue;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;
import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.xml.ws.Endpoint;
import java.net.*;
import java.io.*;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

@WebService(targetNamespace = "http://test")
public class BookService {

  private String APIkey = "AIzaSyCozd0JbgrBxT32kZILK2gKfh7wSKKVOf4";
  private String BankID = "000011112222";

  public static void main(String[] argv) {
    Object implementor = new BookService();
    String address = "http://localhost:9000/BookService";
    Endpoint.publish(address, implementor);
  }

  @WebMethod
  public List<Book> searchBook(String keyword) throws IOException, ParseException {
    URL url = new URL("https://www.googleapis.com/books/v1/volumes?q=" + keyword + "&key=" + APIkey);
    StringBuffer content = connectHttpUrl(url);

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
      Book b = new Book(id, title, author, description, thumbnail, category_list);
//      System.out.println(id);
//      System.out.println(title);
//      System.out.println(author);
//      System.out.println(description);
//      System.out.println(thumbnail);
//      System.out.println(category_list);
//      System.out.println(book);
      book_list.add(b);
      System.out.println(b);
    }
    System.out.println(items);
    Gson gson = new Gson();
    String JSON_result = gson.toJson(book_list);
    System.out.println(JSON_result);
    return book_list;
  }

  public void buyBookByID(String BookID, String UserID) throws IOException{
    // localhost:4000/transfer?send=123412341234&rcv=040214100804&amount=0&time=2018-11-15%2000:00:00
    SimpleDateFormat dateFormatter = new SimpleDateFormat("yyyy-MM-dd%20HH:mm:ss");
    Date date = new Date();
    String varTime =  dateFormatter.format(date);
    String varAmount = "0"; // testing purposes

    URL url = new URL("http://localhost:4000/transfer?send="+UserID+"&rcv="+BankID+"&amount="+varAmount+"&time="+varTime);
    StringBuffer received = connectHttpUrl(url);
    System.out.println(received);

  }

  private StringBuffer connectHttpUrl(URL url) throws IOException{
    HttpURLConnection con = (HttpURLConnection) url.openConnection();
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
    return content;
  }

}