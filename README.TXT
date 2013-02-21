CustomHTML like widget for presta
---------------------------------

1. Navigate to Preferences - PSWidget
2. Add new pswidget item with name (i.e. "test") and text field filled.
3. Modify your whatever-template.tpl, adding pswidget call.

	{pswidget action="text" id="test" cache=300}

4. Thats it. 
                    


Widget Fields:
--------------

Name - block identifier
Title - block title
Text - block content

[x] Plain - do not use smarty pass.

	You can use smarty tags in 'text' field.
	For example {$smarty.now} displays current timestamp.

[x] Raw - do not render any box/borders for this widget (if any)

[x] Active - toggle status


