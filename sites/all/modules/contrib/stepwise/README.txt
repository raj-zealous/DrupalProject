ABOUT STEPWISE
--------------
The Stepwise module provide a flexible way for module developers, site maintainers
and any Drupal fellows to improve your users first experience of your Drupal product.
Stepwise provides a UI to easily create custom configuration workflows and an API for
process the previously builded workflows. Stepwise workflows are basically Drupal modules.
All of these modules connected to the Stepwise API through the hook_stepwise_configuration_info() hook.
So module developers also has the chance for the integration from there modules.


HOW TO USE
----------
The conception of the module usage is the same as the Features module's.

- Install the module as usual.
- Go to the admin/config/workflow/stepwise/add page and start to create your stepwise workflow.
- After saving the Name, Description values, you can start to fill up with steps.
- You can find the "Add step" option under the contextual links.
- After finishing the workflow click on the export button and you can download your workflow as a module.
- After installing the module a new element will display in the admin/config/workflow/stepwise page.


API DOCUMENTATION
-----------------
hook_stepwise_configuration_info
