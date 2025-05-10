#include <stdio.h>
#include <stdlib.h>
//node declaraton 
struct node{
		int data;
		struct node *next;
		struct node *prev;
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
		                                       
	return head;
}
//Function to print list
void printList (struct node *head,int a){
	int i=0;
	struct node *ptr;//the star again !???
	 ptr=head; 
		
		 while(i<a){
			printf(" %d ->",ptr->data);
			ptr=ptr->next;
			i++;
		}

}
//  
void connect(struct node *head){
	struct node *temp1=head;
	struct node *temp2=head;
	while (temp2->next!=NULL){
		temp2=temp2->next;
	}
	temp2->next=head;
	temp1->prev=temp2;
}

struct node * rotate(struct node *head){
	struct node *temp;
	struct node *store1=head;
	store1->data=head->data;
	struct node *store2=head->next;
		head=store2;
	temp=head;
		if(temp->next=NULL){
			temp=store1;
			temp->data=store1->data;
			temp->next=head;
		}
		else{
			temp=temp->next;
		}
return head;
}
	                   
int main (){                 
					                     
	int n,i,a;
	struct node *head;
	printf("How many integers do you want to enter? ");
	scanf("%d",&a);
	for ( i=0;i<a;i++){
		printf("Enter an integer ");
		scanf("%d",&n);
		head=CreateNode(head,n);
	}
	connect(head);
	printList(head,a);
	int p;
	printf("\nBy how many steps do you want to rotate: ");
	scanf("%d",&p);
	for (i=0;i<p;i++){
		head=rotate(head);
	}
	printList(head,a);
	return 0;
}