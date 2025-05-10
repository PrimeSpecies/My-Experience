#include <stdio.h>
#include <stdlib.h>
//node declaraton 
struct node{
		int data;
		struct node *next;
	};

//Function to create node 
struct node *CreateNode(struct node *head,int data){
	struct node *newNode;// idk why the star is necessary
	if (head == NULL){
		head = malloc(sizeof (struct node));// need explanation here 
		if (head == NULL){
			printf("Error! memory is not available\n");
			exit(0);//here too
		}
		head->data=data;
		head->next=NULL;
	}
	else{
		newNode = malloc(sizeof (struct node));
		if (newNode == NULL){
			printf("Error! memory is not available\n");
			exit(0);
		}
		newNode->data=data;
		newNode->next=head;
		head=newNode;                                       
	}
		                                       
	return head ;
}
//Function to print list
void printList (struct node *head){
	struct node *ptr;//the star again !???
	for (ptr=head; ptr!=NULL; ptr=ptr->next){
		printf("%d -> ",ptr->data);
	}
	printf("NULL");
}


int main (){
	int n,a;
	struct node *head = NULL;
	printf("How many integers do you want to enter? ");
	scanf("%d",&a);
	for (int i=0;i<a;i++){
		printf("Enter an integer ");
		scanf("%d",&n);
		head=CreateNode (head,n);
	}
	printList(head);
	
}