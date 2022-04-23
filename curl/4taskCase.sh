
# remote web server
ip="192.168.75.129"
out="./$0.log"
echo -n >$out

# Test Create tasks
echo -e "--Test Create tasks\n" >>$out
curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/task" \
  --data '{"accountId":1,"taskListId":1,"taskName":"task111","status":1,"dueDate":"2022-04-22", "note":"note111"}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/task" \
  --data '{"accountId":2,"taskListId":2,"taskName":"task221","status":1,"dueDate":"2022-04-22", "note":"note221"}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/task" \
  --data '{"accountId":2,"taskListId":2,"taskName":"task222","status":1,"dueDate":"2022-04-22", "note":"note222"}' \
  >>$out
echo -e "\n" >>$out

curl -X POST -H 'Content-Type: application/json' -i "http://$ip/api/task" \
  --data '{"accountId":2,"taskListId":3,"taskName":"task231","status":1,"dueDate":"2022-04-22", "note":"note231"}' \
  >>$out
echo -e "\n" >>$out

# Test List tasks
echo -e "--Test List tasks\n" >>$out
curl -X GET -i "http://$ip/api/task" >>$out
echo -e "\n" >>$out

# Test Read task 3
echo -e "--Test Read task 3\n" >>$out
curl -X GET -i "http://$ip/api/task/3" >>$out
echo -e "\n" >>$out

# Test List tasks by account 2
echo -e "--Test List tasks by account 2\n" >>$out
curl -X GET -i "http://$ip/api/task1/2" >>$out
echo -e "\n" >>$out

# Test List tasks by account 2, taskList 2
echo -e "--Test List tasks by account 2, tasklist 2\n" >>$out
curl -X GET -i "http://$ip/api/task1/2/2" >>$out
echo -e "\n" >>$out

# Test Modify task 4
echo -e "--Test Modify task 4\n" >>$out
curl -X PUT -H 'Content-Type: application/json' -i "http://$ip/api/task/4" \
  --data '{"accountId":2,"taskListId":3,"taskName":"task231b","status":1,"dueDate":"2022-01-01", "note":"note231b"}' \
  >>$out
echo -e "\n" >>$out
echo -e "--Check List of tasks\n" >>$out
curl -X GET -i "http://$ip/api/task" >>$out
echo -e "\n" >>$out

# Test Delete task 4
echo -e "--Test Delete task 4\n" >>$out
curl -X DELETE -i "http://$ip/api/task/4" >>$out
echo -e "\n" >>$out
echo -e "--Check List of tasks\n" >>$out
curl -X GET -i "http://$ip/api/task" >>$out
echo -e "\n" >>$out
