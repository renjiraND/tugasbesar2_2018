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
}
