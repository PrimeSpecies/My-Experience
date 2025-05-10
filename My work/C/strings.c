#include <stdio.h>
#include <string.h>
int main (){
	char string[20];
	int numChar,i;
	printf("Enter a string: ");
	scanf("%s",&string);
	numChar = strlen(string);
	//number of characters
	printf("'%s' has %d characters ",string,numChar);
	//ptint string 10 times
	for( i=0;i < 10;i++){
		printf("\n%s",string);
	}
	//first character of string
	printf("First character is '%c'\n",string[0]);
	//first three characters
	printf("The first three characters are: "); 
	for(i=0; i < 3; i++){
		printf("%c ",string[i]);
	}
	//Last three characters 
	printf("\nThe last three characters are: ");
	if (numChar >= 3){
		for(i=numChar-3;i <= numChar; i++) {
			printf("%c ",string[i]);
		}
	}
	else{
		printf(" Error!!! The string is too short to print last three characters");
	}
	//Print string backwords 
	printf("\nBackwards string: ");
	for(i=numChar;i>=0; i--) {
		printf("%c",string[i]);
	}
	//Print 7th character of the string 
	printf("\nThe seventh character of the string is: ");
	if (numChar<6){
		printf("Oups!! String too short ");
	}else{
		printf("%c",string[6]);
	}
	//First and last characters removed
	printf("\nFirst and last characters removed: ");
	for(i=1;i<numChar-1; i++) {
		printf("%c",string[i]);
	}
	//String in all caps
	printf("\nString in all caps: ");
	for(i=0;i<numChar; i++) {
		printf("%c",toupper(string[i]));
	}
	/**/
}