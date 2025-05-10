#include <stdio.h>
int i,j,k,T[20],count=0,sl,sr,temp,n;
int A[20],left[20],right[20];
void moveAnt(int A[]){
	if (A==left){
		for (i=0; i<sl;i++){
			temp=left[i];
			temp--;
			left[i]=temp;
		}
	}
	else {
		for (i=0; i<sr;i++){
			temp=right[i];
			temp--;
			right[i]=temp;
		}
	}
}

void initTime(int T[]){
	for (i=0;i<20;i++){
		T[i]=0;
	}
}

void checkFall(int A[]){
	if (A==left){
		for (j=0;j<sl;j++){
			if(left[j]==0){
				T[j]++;
				count++;
			}
			else {
				T[j]--;
				count++;
			}
		}
	}
	else{
			for (j=0;j<sr;j++){
				if(right[j]==n){
					T[j]++;
					count++;
				}
				else {
					T[j]--;
					count++;
				}
			}
	}
}

void checkCollision (int left[],int right[]){
	if (sl<=sr){
		for (i=0;i<sr;i++){
			for(k=0;k<sl;k++){
				if (left[k]==right[i]){
					temp=left[k];
					left[k]=right[i];
					right[i]=temp;
				}
			}
		}
	}else {
		for (i=0;i<sl;i++){
			for(k=0;k<sr;k++){
				if (left[k]==right[i]){
					temp=left[k];
					left[k]=right[i];
					right[i]=temp;
				}
			}
		}
	}
}

int main (){
	printf("Enter n: ");
	scanf("%d",&n);
	printf("\nEnter the size of left[]: ");
	scanf("%d",&sl);
	for(i=0;i<sl;i++){
		printf("\nEnter an element for left[]: ");
		scanf("%d",&left[i]);
	}
	printf("\nEnter the size of right[]: ");
	scanf("%d",&sr);
	for(i=0;i<sr;i++){
		printf("\nEnter an element for right[]: ");
		scanf("%d",&right[i]);
	}
	while (count<(sl+sr)){
		j++;
		moveAnt(left);
		moveAnt (right);
		checkFall(left);
		checkFall(right);
		checkCollision(left,right);
	}
	j=0;
	while (j<20){
	//	if (T[j+1]==0){
			printf("The last fall time is %d\n",T[j]);
	//	}
		j++;
	}
	
	return 0;
}