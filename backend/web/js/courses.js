$(".dynamicform_courses").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".dynamicform_courses").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_courses").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_courses").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_courses").on("limitReached", function(e, item) {
    alert("Limit reached");
});