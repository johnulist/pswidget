PSWidget use
------------
in template action

{pswidget action="[group/]action" value="x" value2="y" cache=Nsec}

calls 

PSWidgetWidget::render($action, $params);

  --> load class from /overrides/pswidget/group/action.php
  --> create GroupActionPSWidget
  --> call GroupActionPSWidget->_run
  --> render data with themes/current/pswidget/group/action.tpl


