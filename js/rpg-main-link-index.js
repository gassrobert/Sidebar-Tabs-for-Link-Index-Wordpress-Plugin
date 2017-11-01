jQuery(document).ready(function($) {

  // The user clicks on a tab
  $(document).on('click','.rpgTabTitle', function(){

    // obtain the classes of the clicked tab
    var tabClass = $(this).attr("class");

    // Check if the class is active or not
    // If it's active do nothing
    // If it's not active yet switch the tabs and links
    if (tabClass == "rpgTabTitle rpg_tab_active") {
      return;
    } else {
        // Change the id of the currently active tab
        var allOldTabInt = document.getElementsByClassName('rpgTabTitle rpg_tab_active');
        for (var i = 0; i < allOldTabInt.length; i++) {

          allOldTabInt[i].id = 'rpgTabInactiveId';

        } 

        // Change the id of the clicked tab
        var allNewTabInt = document.getElementsByClassName(tabClass);
        for (var i = 0; i < allNewTabInt.length; i++) {

          allNewTabInt[i].id = 'rpgTabActiveId';

        } 

        // Switch the classes between the two tabs so the clicked tab 
        // becomes the active tab and the other tab is no longer active
        document.getElementById('rpgTabInactiveId').className = tabClass;
        document.getElementById('rpgTabActiveId').className = "rpgTabTitle rpg_tab_active";

        // Remove the id values from the two tabs
        var allOldTabInt = document.getElementsByClassName('rpgTabTitle rpg_tab_active');
        for (var i = 0; i < allOldTabInt.length; i++) {

          allOldTabInt[i].id = '';

        } 
        var allNewTabInt = document.getElementsByClassName(tabClass);
        for (var i = 0; i < allNewTabInt.length; i++) {

          allNewTabInt[i].id = '';

        } 

        // cause the links of the previously active tab to slide up and display none.
        $( ".rpg_link_active" ).slideUp("fast");   

        // Obtain the links of the currently selected tab
        var tabIntArray = tabClass.split("_");
        var tabInt = tabIntArray[2];
        var newTabIntLink = 'rpg_link_' + tabInt;

 
        // Give names to the active and inactive links and show the active links
        var all = document.getElementsByClassName('rpg_link_active');
        for (var i = 0; i < all.length; i++) {

          all[i].name = 'rpgInactiveName';
        } 
        var allNewLinkInt = document.getElementsByClassName(newTabIntLink);
        for (var i = 0; i < allNewLinkInt.length; i++) {
          allNewLinkInt[i].style.display = 'block';
          allNewLinkInt[i].name = 'rpgActiveName';
        } 

        // Use the names given to switch the classes 
        $('[name="rpgInactiveName"]').addClass(newTabIntLink).removeClass('rpg_link_active');
        $('[name="rpgActiveName"]').addClass('rpg_link_active').removeClass(newTabIntLink);

        // Remove the values from the names
        var all = document.getElementsByClassName('rpg_link_active');
        for (var i = 0; i < all.length; i++) {
          all[i].name = '';
        } 
        var allNewLinkInt = document.getElementsByClassName(newTabIntLink);
        for (var i = 0; i < allNewLinkInt.length; i++) {
          allNewLinkInt[i].name = '';
        }       

    } // End of if (tabClass == "rpgTabTitle rpg_tab_active") {

  }); // End of $(document).on('click','.rpgTabTitle', function(){

}); // End of jQuery(document).ready(function($) {

