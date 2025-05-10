#include <stdio.h>
int Search(int array[],int pos,int k){//This function compares each element of the array
	int i;
	 if (k==array[pos]){
		return 	printf("\n%d is found at position %d",k,pos+1);
	}
	else{
		pos++;
		Search(array,pos, k);
		}
	else{
		return printf("%d not found in the list",k);
	}
}
			
int main (){
	int A[]={5,3,5,2,6,1,56,3};//You can modify the array if you wish !
	int a;
	printf("Enter a number to search: ");
	scanf("%d",&a);
	Search (A,0,a);
	return 0;
}       

//This program won't count the occurences of an input       