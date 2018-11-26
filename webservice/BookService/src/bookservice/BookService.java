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
import java.text.*;
import java.util.*;

@WebService(targetNamespace = "http://test")
public class BookService {

  private String APIkey = "AIzaSyCozd0JbgrBxT32kZILK2gKfh7wSKKVOf4";
  private String BankID = "000011112222";

  public static void main(String[] argv) {
    Object implementor = new BookService ();
    String address = "http://localhost:9000/BookService";
    Endpoint.publish(address, implementor);
  }

  @WebMethod
  public String searchBook(String keyword) throws IOException,ParseException {
    System.out.println("1");
    URL url = new URL("https://www.googleapis.com/books/v1/volumes?q="+keyword+"&key="+APIkey);
    StringBuffer content = connectHttpUrl(url);

    String json_string;

    JSONParser jsonParse = new JSONParser();
    json_string = content.toString();

    JSONObject JSONBooks = (JSONObject) jsonParse.parse(json_string);


//    for (int i = 0; i < ; i++) {
//      JSONObject object = (JSONObject) JSONBooks.get(i);
//      System.out.println(object);
//    }
    System.out.println(JSONBooks.get("totalItems"));
    return json_string;
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
