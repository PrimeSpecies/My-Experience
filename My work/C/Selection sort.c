#include <stdio.h>
int main (){
	int a[5]={10,9,1,7,3};
	int k,i,j,temp,n;
	for (i=0;i<4;i++){
		k=i;
		for(j=i+1;j<5;j++){
			if (a[j]<a[k]){
				temp=a[j];
				a[j]=a[k];
				a[k]=temp;
				k=j;
			}
		}
	}
	for (n=0;n<5;n++){
		printf("%d ",a[n]);
	}
	return 0;
}