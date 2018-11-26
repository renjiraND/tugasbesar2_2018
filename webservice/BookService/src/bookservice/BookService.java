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
import java.util.ArrayList;
import java.util.List;

@WebService(targetNamespace = "http://test")
public class BookService {

  public String APIkey = "AIzaSyCozd0JbgrBxT32kZILK2gKfh7wSKKVOf4";

  public static void main(String[] argv) {
    Object implementor = new BookService ();
    String address = "http://localhost:9001/BookService";
    Endpoint.publish(address, implementor);
  }

  @WebMethod
  public List<Book> searchBook(String keyword) throws IOException,ParseException {
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

    Long item_number = (Long) JSONBooks.get("totalItems");
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
      String author = "";
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
      if(imageLinks == null) {
        thumbnail = "default";
      } else{
        thumbnail = (String) imageLinks.get("thumbnail");
      }
      //Get Category
      List<String> category_list = new ArrayList<String>();
      JSONArray categories = (JSONArray) volume_info.get("categories");
      if (categories == null){
        category_list.add("None");
      } else {
        for (Object c : categories){
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
}