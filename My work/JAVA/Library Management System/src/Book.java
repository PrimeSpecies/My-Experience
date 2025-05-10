public class Book extends LibraryItem {
    int pages;
    String author;

    @Override
    public void displayDetails() {
        super.displayDetails();
        System.out.println("Pages: "+this.pages+"\nAuthor: "+this.author);
    }
    Book(String title,int ID,int pages, String author){
        super(title,ID);
        this.pages = pages;
        this.author= author;
    }
}
