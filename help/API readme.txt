
-----------------------
Account

GET	/api/account
get all accounts

GET	/api/account/id
id is a placeholder for the accountId value.
get the account identified by the id value.

GET	/api/account1/login
login is a placeholder for the login value.
get the account identified by the login value.

POST	/api/account
with header Content-Type: Application/json
with a body
create an account.

PUT	/api/account/id
id is a placeholder for the accountId value.
with header Content-Type: Application/json
with a body
update the account identified by the id value.

DELETE	/api/account/id
id is a placeholder for the accountId value.
delete the account identified by the  id value.

GET	/api/accountM/confirm/id
id is a placeholder for the accountId value.
Confirm account 1 : send a mail to confirm registration

GET	/api/accountM/activate/id/activation_code
id is a placeholder for the accountId value.
activation_code is a placeholder for the activation code sent by mail during the confirm request.


-----------------------
TaskList

GET	/api/tasklist
get all tasklists

GET	/api/tasklist1/accountId
accountId is a placeholder for an account id value.
get all tasklists linked to an account identified by the accountId value.

GET	/api/tasklist/id
id is a placeholder for the taskListId value.
get the tasklist identified by the id value.

POST	/api/tasklist
with header Content-Type: Application/json
with a body
create a tasklist.

PUT	/api/tasklist/id
id is a placeholder for the taskListId value.
with header Content-Type: Application/json
with a body
update the tasklist identified by the id value.

DELETE	/api/tasklist/id
id is a placeholder for the taskListId value.
delete the tasklist identified by the  id value.


-----------------------
Task

GET	/api/task
get all tasks

GET	/api/task1/accountId
accountId is a placeholder for an account id value.
get all tasks linked to an account identified by the accountId value.

GET	/api/task1/accountId/taskListId
accountId is a placeholder for an account id value.
taskListId is a placeholder for a tasklist id value.
get all tasks linked to an (account, tasklist) identified by the (accountId, taskListId) values. 

GET	/api/task/id
id is a placeholder for the taskId value.
get the task identified by the id value.

POST	/api/task
with header Content-Type: Application/json.
with a body.
create a task.

PUT	/api/task/id
id is a placeholder for the taskId value.
with header Content-Type: Application/json
with a body
update the task identified by the id value.

DELETE	/api/task/id
id is a placeholder for the taskId value.
delete the task identified by the  id value.


