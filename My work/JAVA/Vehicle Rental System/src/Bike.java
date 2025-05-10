public class Bike extends Vehicle {
    boolean electric;

    @Override
    void details() {
        super.details();
        System.out.println("Vehicle Number: "+this.vehicleNumber+"\nVehicle brand: "+this.brand+"\nRental Rate: "+this.rentalRate+"\nElectric: "+this.electric);
    }
}
