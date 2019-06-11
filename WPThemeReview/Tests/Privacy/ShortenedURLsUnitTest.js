// Check for url shorteners used in themes. Examples found in existing theme repository.
var MAX_UID = 1000000; // Shoutout AngusCroll (https://goo.gl/pxwQGp) // BAD

// Note, Android < 4 will pass this test, but can only animate
//   a single property at a time
//   goo.gl/v3V4Gp // BAD
tests['cssanimations'] = function() {
    var link = 'ow.ly/Loi7tf$'; // BAD
    return link;
};
/**
 * Thanks to Jason Bunting via StackOverflow.com
 *
 * http://stackoverflow.com/questions/359788/how-to-execute-a-javascript-function-when-i-have-its-name-as-a-string#answer-359910
 * Short link: http://tinyurl.com/executeFunctionByName // BAD
 **/
 const okLink = 'https://www.google.com/';

 // You can see the info here: soo.gd/09ujGt43 or here: df.ly/Lok487a // BAD
