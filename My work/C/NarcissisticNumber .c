/*
#include <stdio.h>
int main (){
	int n,a,sum=0,count=1;
	const N;
	printf("Enter a number \n");
	scanf("%d",&N);
	n=N;
	while (n>0){
		a=n%10;
		sum=sum+(a*a);
		n=n/10;
		count++;
	}
	if (sum==N){
		printf("%d is a narcissistic number ",N);
	}else{
		printf ("%d is not a narcissistic number ",N);
	}
	return 0;
}
*/
/*Exercise 16:
A narcissistic number (or Armstrong number of the first kind) is a nonzero natural number n that is equal to the sum of the p-th powers of its digits in base ten, where p denotes the number of digits of n:
Example:
153 = 1^3+5^3+3^3
548834 = 5^6+46+86+86+36+46
Write an algorithm that reads a natural number and checks if it is a narcissistic number.
*/
/*#include <stdio.h>
int main(){
	int n,count=0,i=0,b[10];
	while (n>0){
		b[i]=n%10;	
		count++;
	}
	while (i>0){
		
		for (int j=1;j<count;j++){
		}
	
	}
	return 0;
}
 #include <stdio.h>
int main(){
	int n,power=0,i=0,b[10];
	while (n>0){
		n = n/10;
		i++;
		power++;
	}
	while (n>0){
		
		
		}
	
	}
	return 0;
}#include <stdio.h>
int main(){
	int n,power=0,i=0,b[10];
	while (n>0){
		n = n/10;
		i++;
		power++;
	}
	while (n>0){
		
		
		}
	
	}
	return 0;
}*/

#include <stdio.h>
int main(){
	int n, power=0, individual_pow[10];
	int individual, reset = 0 , i=0, j, sum=0;
	
	printf("enter number");
	scanf("%d",&n);
	
	while (n>0){
		n = n/10;
		power += 1;
	}
	
	printf("%d ",power);
	
	while (n>0){
		
		individual = n % 10;
		reset = individual;
		n = n/10;
		
		for(j=0 ; j<power ; j++){
			individual = individual * reset;
			printf("%d ",j);
		}
	
		individual_pow[i] = individual ;
		i++;
		
		}
		
		for(j=0 ; j<=i ; j++){
			sum = sum + individual_pow[j];
		}
	printf("   %d",sum);
	
	return 0;
	}
	
