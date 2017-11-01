jQuery(document).ready(function($) {

  // The user clicks on the tab heading
  $(document).on('click','.rpgAccordionHeading', function(){

    // Open or close the list of links for the clicked tab heading
    $(this).next(".rpgAccordion").slideToggle("slow");    

  });
});