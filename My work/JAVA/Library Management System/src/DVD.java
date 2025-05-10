public abstract class DVD extends LibraryItem{
    int duration;
    String genre;

    @Override
    public void displayDetails() {
        super.displayDetails();
        System.out.println("Duration: "+this.duration+"\nGenre: "+this.genre);
    }

}
