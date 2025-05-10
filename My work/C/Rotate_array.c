#include <stdio.h>
int main (){
	int a[20];
	int temp,n=0,i,ini=0;
	int count;
	int size;
	printf("How many numbers are in your array ");
	scanf("%d",&size);
	printf("\nEnter the values:\n");
	for (i=0;i<size;i++){
		scanf("\n%d",&a[i]);
	}
	printf("\nEnter the number of rotations: ");
	scanf("%d",&count);
	
	while(n<count){
		temp=a[size-1];
		for ( i=size-1;i>=1;i--){
			a[i]=a[i-1];
		}
	a[ini]=temp;
	n++;
	}           
	printf("Rotated ouput: ");
	for (i=0;i<size;i++){
		printf("%d ",a[i]);
	}
	return 0;
}