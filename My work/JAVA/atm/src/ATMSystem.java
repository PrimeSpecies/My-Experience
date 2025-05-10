import java.util.Scanner;

public class ATMSystem {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        double balance = 0.0;

        while (true) {
            // Display the menu
            System.out.println("\nATM Menu:");
            System.out.println("1. Check Balance");
            System.out.println("2. Deposit Money");
            System.out.println("3. Withdraw Money");
            System.out.println("4. Exit");
            System.out.print("Choose an option: ");
            int choice = scanner.nextInt();

            // Process user choice using an if-else block
            if (choice == 1) {
                System.out.println("Your current balance is: " + balance);
            } else if (choice == 2) {
                System.out.print("Enter the amount to deposit: ");
                double deposit = scanner.nextDouble();
                if (deposit > 0) {
                    balance += deposit;
                    System.out.println("You have successfully deposited " + deposit);
                } else {
                    System.out.println("Invalid amount. Please try again.");
                }
            } else if (choice == 3) {
                System.out.print("Enter the amount to withdraw: ");
                double withdraw = scanner.nextDouble();
                if (withdraw > 0 && withdraw <= balance) {
                    balance -= withdraw;
                    System.out.println("You have successfully withdrawn " + withdraw);
                } else if (withdraw > balance) {
                    System.out.println("Insufficient balance!");
                } else {
                    System.out.println("Invalid amount. Please try again.");
                }
            } else if (choice == 4) {
                System.out.println("Thank you for using the ATM. Goodbye!");
                break; // Exit the loop
            } else {
                System.out.println("Invalid choice. Please try again.");
            }
        }

        scanner.close();
    }
}
