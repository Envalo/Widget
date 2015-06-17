# Envalo_Widget
## A Two Part Module
* Bug fix for CMS Widgets in Magento 1.X
* Enhance Widgets to allow choosing specific CMS pages for layout updates

In Magento, the CMS Widget editor you use to configure widgets through the admin has a bug. If you use custom
block references that are tied to specific layout handles, saving and loading the widget editor will result in
your custom block reference not showing any value. Additionally the dropdown for block references will only show
default references. This is all detailed in the following blog post: http://www.envalo.com/magento-widgets-annoying-bug-fixed/

This module fixes the bug.

Additionally, with this module you can now specify specific CMS pages when creating layout updates in the widget editor.
This is a feature I felt that Magento Widgets was seriously lacking.

The blog posts for this can be found here:

www.envalo.com/enhancing-magento-widgets-choosing-specific-cms-pages-part-1/

www.envalo.com/enhancing-magento-widgets-choosing-specific-cms-pages-part-2/


The module has been tested in both community and enterprise editions.