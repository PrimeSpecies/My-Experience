# include <iostream>
#include <vector>
#include <cstdlib>
#include<string.h>

using namespace std;

string A;

int top = -1;
//vector<int> stack;
vector<char> stack;
int n=30;

void push(char x) {
    if (top >= n - 1) {
        cout << " \n Stack Overflow.." << endl;
    } else {
        
        top = top + 1;
        stack.push_back(x);
        stack[top] = x;
        
    }
}

void pop() {
    if (top == -1) {
        cout << "Stack is Underflow" << endl;
    } else {
        //cout << "Delete data " << stack[top] << endl;
        top = top - 1;
    }
}

void display() {
    if (top == -1) {
        cout << "Stack is Underflow" << endl;
    } else {
        cout << "Display elements are:" << endl;
        for (int i = top; i >= 0; i--) {
            cout << stack[i] << endl;
        }
        exit(0);
    }
}
string b='({[';

void checkBracketBalence(string y){
	int s=y.length(); 
	char c;
	for(int i=0; i<s;i++){
		c=char(y[i]);
		
		if( y[i]== char('(') )
		
		{
			
			push('(');
		
		}
		
		if( y[i]== char(')') ){
			
			if(top <0)
			{cout <<" brakets mismatch"<<endl;
				for(int j=0; j<s;j++ ){
					cout << y[j];
				}
				cout <<endl;
				for(int j=0; j<i;j++ ){
					cout << " ";
				}
				cout << "--" <<endl;
				return;
			}
			else{
				
				if(  stack[top]=='(' ){
			
			pop();
			}
			else {
				cout << " brakets mismatch"<<endl;
				for(int j=0; j<s;j++ ){
					cout << y[j];
				}
				cout <<endl;
				for(int j=0; j<=i;j++ ){
					cout << " ";
				}
				cout << "--" << endl;
			}
			}
			
			
		}
	}
	
	if (top <0){
		cout<< " good brackets matching";
	}
	else {
		for(int j=0; j<s; j++ ){
					cout << y[j];
				}
		cout << endl << "--" << endl;
		cout << " brakets mismatch " << endl;
	}
	
	return;
}


int main(){
	
	cout<<" enter the math string: ";
	cin>>A;
	
	checkBracketBalence(A);
	
	return 0;
}
