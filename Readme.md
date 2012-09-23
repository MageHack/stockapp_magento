# Stock App

An iOS app that allows Magento administrators to update their product stock levels using a barcode and an iPhone.  You can see an awesome (!) video of it in action at https://vimeo.com/50003370.

![image](http://dl.dropbox.com/u/192363/github/stockapp/ios_scan.png)
![image](http://dl.dropbox.com/u/192363/github/stockapp/ios_qty.png)

## Instructions

This project comes in two parts, the [iOS app](https://github.com/MageHack/stockapp) and the [Magento Extension](https://github.com/MageHack/stockapp_magento).

You can install the Magento extension by running the following commands:

    cd $magento_root
    mkdir .modman
    cd .modman
    git clone https://github.com/MageHack/stockapp_magento.git stockapp
    cd ..
    modman deploy stockapp
    
Once you've added the Magento extension to your Magento installation you have to do some initial setup.  All of the configuration for this extension is stored in `System > Configuration > Catalog > Inventory > iOS Stock Updater`.  There are three options:

![image](http://dl.dropbox.com/u/192363/github/stockapp/config_section.png)

* **Enable**: If this is set to `No`, then incoming requests to the stock updating controller will not be handled.
* **API Key**: You'll need to share this secret with the iOS device in order to authenticate the communication.
* **Barcode Attribute**: This is the product attribute that you need to setup to store the barcode information against each product.

## Setting up the Barcode Attribute
	
This is easy.  Just set up a sensible looking attribute in the backend, add it to your attribute sets and select it from the dropdown in the configuration section.

![image](http://dl.dropbox.com/u/192363/github/stockapp/config_barcode.png)

## Todo

* Allow for modifying the base url of the Magento store (kind of a high priority, I know)
* Allow for autoconfiguration by scanning a QR code in the admin area