#include <stdio.h>
int main(){
	int A[]={2,4,5,6,30,32};
	int left,right,mid,n;
	left=0;
	right =sizeof(A)/sizeof(A[0]);
	printf("Enter a number to search\n");
	scanf("%d",&n);
	
	mid =(left+right)/2;
	while(right>left){
		if (n>A[mid]){
			left=mid+1;
		}
		else if (n==A[mid]){
			break;
		}
		else if (n<A[mid]){
			right=mid-1;
		}
	}
	printf("The position of %d is %d",n,mid);

	return 0;
}