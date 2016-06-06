#GIT Useful Commands

- Create New Branch
git checkout -b <branch-name>

- Check Current Branch
git branch

- Move one branch to another branch
git checkout <branch-name>
git branch

- Check status of current branch
git status

- Save new or updated files
git status
git add -A
git commit -m "Write your message"
git pull origin <current-branch-name>
git push origin <current-branch-name>

- Merge Branch from one to another, Suppose you want to merge staging branch into master follow the below steps
git branch    // Will shown you your current branch
git checkout master  // you must have to move into master branch
git pull origin master   // Must have to take pull
git merge staging   // staging branch will merge with master branch
git push origin master  // We have to push updated changes on master branch