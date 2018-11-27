package bookservice;

import java.io.Serializable;
import java.util.List;

public class Book implements Serializable {
    private String id;
    private String title;
    private String authors;
    private String description;
    private String imageLinks;
    private List<String> categories;

    public Book() {
    }

    public Book(String id, String title, String authors, String description, String imageLinks, List<String> categories) {
        this.id = id;
        this.title = title;
        this.authors = authors;
        this.description = description;
        this.imageLinks = imageLinks;
        this.categories = categories;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getAuthors() {
        return authors;
    }

    public void setAuthors(String authors) {
        this.authors = authors;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getImageLinks() {
        return imageLinks;
    }

    public void setImageLinks(String imageLinks) {
        this.imageLinks = imageLinks;
    }

    public List<String> getCategories() {
        return categories;
    }

    public void setCategories(List<String> categories) {
        this.categories = categories;
    }

    @Override
    public String toString() {
        return "Book{" +
                "id='" + id + '\'' +
                ", title='" + title + '\'' +
                ", authors='" + authors + '\'' +
                ", description='" + description + '\'' +
                ", imageLinks='" + imageLinks + '\'' +
                ", categories=" + categories +
                '}';
    }
}
