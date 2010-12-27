# PhotoShow documentation

This document consists of 3 parts:

* [What is PhotoShow ? : presentation](#what_is_photoshow)
* [How to install PhotoShow ?](#installation_guide)
* [Settings and security](#settings_and_security)

I really suggest looking at the [Wiki](https://github.com/thibaud-rohmer/PhotoShow/wiki).

# What is PhotoShow ?

PhotoShow is a very easy to use, automatically generated website, to display your pictures. Without any configuration needed, it is ready-to-go, as soon as you get the archive. *It doesn't use any database*, and doesn't require any real computer science knowledge. You need a proof ? *My mother uses it.*


# Installation guide

To install PhotoShow, just get the archive. Then, in the photos folder, create your library. Here is an example : 

*photos/Paris/The_Louvre/image01.jpg*

**Warning** : You need to have two levels of folders inside the "photos" folder, and your pictures inside this second level, as shown in the example.

That's it, PhotoShow displays your images. You may drink your glass of whiskey now.

# Settings and security

# Settings, security

## Settings

Check available settings in default_settings.php. You can edit those settings in the settings.php file.

## How to secure your albums

PhotoShow also provides a very easy way to select who will be allowed to see each of your albums.

### Creating a group

First, you need to create a group of users. Let's call it "family".
Go with your browser, to the page called  "addgroup.php". (it is located in your website : http://**yourwebsite**/addgroup.php )

In the "name" field, put "family"
In the "password" field, let's put "42"
Validate.

Now, follow the instructions : copy the line given to you, and paste it into your "pass.php" file, on your server.
Save.

You have created a group. You may drink your glass of whiskey now.

### Protecting an album

You can't protect projects, only albums (I don't really see the point in protecting projects). Go inside one of your albums folders (which means, where your photos are). There, create the file : 

* authorized.txt *

Inside this file, put, on different lines, the name of the groups allowed to see this folder. For instance, I'll put :

	family
	jack

Save.

You have secured your album. Now, if someone wants to see it, he will need to log in as a member of the group "family" or "jack". You may dring your glass of whiskey now.

# Frequently Asked Questions

### No photos and no albums (apart from the generated one)

Check that your server has the rights to write into your main (PhotoShow) folder. If you're unsure, just set it right to 775.

### My photos don't show up at all

Try to restart your computer. Nah, just joking... Have you considered the fact that your photos may not be in the good directory ? You NEED to have two sub-levels inside the "photos" folder.


### I am sure I have my photos in the right folder, but still...

Ok ok... Check the rights of your photos and folders. You need to be able to read (r) the photos, and read and execute (rx) the folders.

### My photos seem to show up, but no thumbnail

If the "thumb" folder hasnt been created in your website, then check the rights for your PhotoShow folder (the main folder).

If the "thumb" folder has been created, check the rights of the folders inside it... This may be the reason of the problem (but shouldn't happen).

### Can a user log in as a member of several groups ?

Yes, as long as the user doesn't close the website, all of the groups he has been logged as will remain valid.
