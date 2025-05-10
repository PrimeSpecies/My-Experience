public class Vehicle {
    int vehicleNumber;
    String brand;
    int rentalRate;

    double rentalCost (int days,int rentalRate){
        return  days*rentalRate;
    }

    void details(){
        System.out.println("Vehicle Number: "+this.vehicleNumber+"\nVehicle brand: "+this.brand+"\nRental Rate: "+this.rentalRate);
    }
}
