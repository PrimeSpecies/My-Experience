public class Car extends Vehicle{
    int seats;

    @Override
    void details() {
        super.details();
        System.out.println("Vehicle Number: "+this.vehicleNumber+"\nVehicle brand: "+this.brand+"\nRental Rate: "+this.rentalRate+"\number of seats: "+this.seats);
    }
}
