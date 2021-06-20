# wills_blackboards
This is a typo3 extension that uses typo3 record system to create posts with an image, title, text and a category from typo3 system categories. Also there is a task manager to make the blackboards expire once the set amount of days pass.
Missing:
* Fall back if the editor forgot to set a private side for loged users at the frontend. If the extension is set for all users once you try to create an idea you will get an error message of not finding the logged user id.
* Also there is a problem for adding both new and list plugins on the same page

1- Add the extension
2- If necessary load the classes on typo3's composer.json file
3- Once is installed you will need to create some of the typo3 system categories to set in the plugin
4- You are gonna need to set the frontend user on your typo3 in order to set the permissions to the page where you add the plugins.
5- Then is just matter to add the plugins and configure them, you will be asked for:
  * A parent category that holds all the categories for Ideas
  * To select the page where the New Blackboards plugin has been added.
  * To select the page where the List Blackboards plugin has been added.
  * The if you want the amount of days until the blackboards expire.
  * And a storage folder to save all the blackboards.
