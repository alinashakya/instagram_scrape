# Instagram Data Scrapping

## Goal
This demo project targets to demonstrate the use of data scraping techniques to scrape the feed data from the instagram Web Interface.

## Configuration
You can use your instagram username and password in `insta_function.php`.

## Running the project
If you have php and curl installed, you should be good. Just clone this repo to your web server and goto `http://localhost/instagram_scrape/instagram.php` from browser. You should see your instagram feeds right there.

## Background

### Why Instagram?
Because I love it and thought it would be fun to see how they manage their UI and how challenging would it be to scrape it.

### Why no Framework?
Just for this, why? its too lightweight.

### The Process    
As always, we have to analyze the web interface and here are the steps we need to take:
- It uses simple urlencoded form to authenticate and returns a sessionid and bunch of other things
- We then need to pass that sessionid in a cookie and request the (homepage)[instagram.com]
- It will return HTML without the actual data, but it gives us URL to load the data through AJAX (_also they use GraphQL_)
- After parsing the DOM with the help of `simple_html_dom.php`, we get that URL.
- We then send the request to the URL using the same credentials (cookie) as before to get the data
- Which we parse and get the image urls, username as well as user links that is needed to populate the UI

### My Assumptions
- You haven't activated 2FA in your instagram account, (_it would have been one more step after sending username and password but it would require a user interaction and I wanted to make it simple_)
- Hope you won't be super excited and try executing it too many times, (_just security feature of instagram, if you login multiple times even if you are correctly logging in, they disable your account for a while_)

### Shortcuts I took (_Things to improve_)
Since it is just a demo, I didn't actually store the data anywhere instead just presented it on the UI.
