# Envalo_Widget
Bug fix for CMS Widgets in Magento 1.X

In Magento, the CMS Widget editor you use to configure widgets through the admin has a bug. If you use custom
block references that are tied to specific layout handles, saving and loading the widget editor will result in
your custom block reference not showing any value. Additionally the dropdown for block references will only show
default references. This is all detailed in the following blog post: TBD

This module fixes the bug. It has been tested in both community and enterprise editions. 