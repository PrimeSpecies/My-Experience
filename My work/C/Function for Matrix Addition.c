#include <stdio.h>
void readArray(int A[int R][int C]){
	for (int i=0;i<R;i++){
		for (int j=0;j<C;j++){
		scanf("%d",&A[i][j]);
		}
	}
}
void sumArray(int A[10][10],int B[10][10],int C[10][10]){
	int row,col;
		for(int i=0;i<row;i++){
			for(int j=0;j<col;j++){
				C[i][j]=A[i][j]+B[i][j];
			}
		}
	}
void printArray (int C[10][10],int row, int col){
	for(int i=0;i<row;i++){
			for(int j=0;j<col;j++){
				printf("%d ",C[i][j]);
			}
		printf("\t");
	}
}
int main(){
	int rA,rB,cA,cB,A[10][10],B[10][10],C[10][10],rC,cC;
	printf ("Enter the number of rows for the First Array \n");
	scanf("%d",&rA);
	printf ("Enter the number of columns for the First Array\n");
	scanf("%d",&cA);
	printf ("Enter the values for the first array");
	readArray(A[rA][cA]);
	printf ("Enter the number of rows for the Second Array \n");
	scanf("%d",&rB);
	printf ("Enter the number of columns for the First Array\n");
	scanf("%d",&cB);
	printf ("Enter the values for the first array\n");
	readArray(B[rB][cB],rB,cB);
	
	sumArray(A[rA][rA],B[rB][cB],C[rC][cC]);
	printArray (C[rC][cC],rC,cC);
	
	return 0;
}