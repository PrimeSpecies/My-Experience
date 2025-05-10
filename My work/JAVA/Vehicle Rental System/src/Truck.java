public class Truck extends Vehicle{
    int capacity;

    @Override
    void details() {
        super.details();
        System.out.println("Vehicle Number: "+this.vehicleNumber+"\nVehicle brand: "+this.brand+"\nRental Rate: "+this.rentalRate+"\nCapacity: "+this.capacity);
    }
}
