# Install Adobe Flash Plugin for Firefox

This is how to install Adobe Flash Plugin for Firefox:
- Go to this page and select the option .tar.gz for other Linux. Download the file.
- Unpack the plugin tar.gz and copy the files to the appropriate location.
- Save the plugin tar.gz locally and note the location the file was saved to.
- Launch terminal [ CTRL + ALT + T ] and change directories to the location the file was saved to.
- Unpack the tar.gz file. Once unpacked you will see the following:
1) libflashplayer.so
2) /usr
- Identify the location of the browser plugins directory, based on your Linux distribution and Firefox version.(Usually it is /usr/lib/mozilla/plugins/)
For ubuntu 14.04 path is : /usr/lib/firefox/browser/plugins
- Copy libflashplayer.so to the appropriate browser plugins directory. At the prompt type:
sudo cp libflashplayer.so <BrowserPluginsLocation>
- Copy the Flash Player Local Settings configurations files to the /usr directory. At the prompt type:
sudo cp -r usr/* /usr
- Now restart your browser.

