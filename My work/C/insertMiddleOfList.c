#include <stdio.h>
#include <stdlib.h>
//Structure of a node 
struct node {
	int data ;
	struct node *next;
};
//Find middle position
int findMiddle (struct node *head ){
	struct node *temp;
	temp=head;
	int mid, count;
	count=0;
	while (temp != NULL){
		temp=temp->next;
		count++;
	}
	mid = (count/2)+1;
	printf("\nmid is %d\n",mid);
	return mid;
}
//Insert in the middle
struct node * insertMiddle(struct node *head , int mid,int data ){
	struct node *nod,*temp;
	temp=head;
	int count=0;
	while (temp->next!=NULL){
		if (count == mid ){
				nod = malloc(sizeof (struct node));
			if (nod == NULL){
				printf("Error! memory is not available\n");
				exit(0);
			}
			nod->data=data;
			nod->next=temp->next;
			temp=nod;
			return head;
		}
		count++;
		temp=temp->next;
	}
	
} 
//Print the list 
void printList (struct node *head){
	struct node *ptr;//the star again !???
	for (ptr=head; ptr!=NULL; ptr=ptr->next){
		printf("%d -> ",ptr->data);
	}
	printf("NULL");
}
//Create a new node 
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

int main (){
	int n,a,b,mid;
	struct node *head = NULL;
	printf("How many integers do you want to enter? ");
	scanf("%d",&a);
	for (int i=0;i<a;i++){
		printf("Enter an integer ");
		scanf("%d",&n);
		head=CreateNode (head,n);
	}
	printList(head);
	
	printf("\nEnter an element to insert in the middle ");
	scanf("%d",&b);
	mid=findMiddle (head);
	insertMiddle(head,mid,b);
//	CreateNode(head,b);	
	printList(head);
	return 0;
}
