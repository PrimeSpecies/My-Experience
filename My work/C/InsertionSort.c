#include <stdio.h>
int main (){
	int a[10],i=0,j,n,temp;
	printf("Enter the number of elements to sort ");
	scanf("%d",&n);
	while(i<n){
		scanf("%d",&a[i]);
		i++;
	}
	for (j=0;j<n;j++){
		for (i=0;i<n;i++){
			if (a[i]<a[i+1]){
				temp=a[i];
				a[i]=a[i+1];
				a[i+1]=temp;
			}
		}
	}
	for (i=n;i>0;i--){
		printf("%d ",a[i]);
	}
	return 0;
}