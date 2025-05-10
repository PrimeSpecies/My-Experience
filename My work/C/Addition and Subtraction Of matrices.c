#include <stdio.h>
int main(){
	int A[2][3]={
	{5,2,3},
	{1,4,0}
	};
	int B[2][3]={
	{1,0,0},
	{0,1,0}
	};
	
	for (int i=0;i<2;i++){
		for(int j=0;j<3;j++){
			printf("%d ",A[i][j]-B[i][j]);
		}
		printf("\n");
	}
	return 0;
}