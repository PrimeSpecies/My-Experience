public abstract class Magazine extends LibraryItem{
    int Isn;
    int pubMonth;

    @Override
    public void displayDetails() {
        super.displayDetails();
        System.out.println("Issue Number: "+this.Isn+"\nPublication Month: "+this.pubMonth);
    }
}
