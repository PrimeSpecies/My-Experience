#include <stdio.h>
int main(){
	int hour,min;
	printf("Enter the time in hh:mm format\n");
	scanf("%d:%d",&hour,&min);
	min +=5;
	if (min>59){
		hour++;
		min-=60;
	}
	printf("The time is %d:%d",hour,min);
	return 0;
}
