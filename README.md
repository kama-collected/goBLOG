# goBLOG
## Git Setup

Either you download from the browser and do push requests from there or you can use the command prompt. I personally use the terminal as it shows all the files you changed in VS Code itself. Easier to keep track.

If you are using the terminal, you can check if its downloaded already using:

> git --version

Set path

> cd ....

Download the repo

> git clone https://github.com/kama-collected/goBLOG.git

Go into the folder whereever you stored it

> cd /..../goBLOG

Set Identity (if first time)

> git config --global user.name "Your Full Name" git config --global user.email "your@email.com"

Create a branch for you part

> git checkout -b your-name-feature

Pull code before starting work to sync with latest changes made by others (if any)

> git pull origin master

Upload your part once work is done

> git add . 

> git commit -m "Added feature X" 

> git push origin your-name-feature

## Running Instructions

First open up a terminal

> php artisan migrate

> php artisan db:seed

Then open command prompt

> npm install --save-dev vite laravel-vite-plugin (if not yet installed)

> npm run dev

I havent even seen the admin profile as of now so we might have quite a bit to do there. You can find the sidebar menu under resources/views/layouts if you want to start routing to other pages (especially for editing user profile). I also have not integrated the authorization and authentication part someone made as i started integrating from Alvin's folder.