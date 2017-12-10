$(document).ready(function()
{
  $('.code-wrapper code').each(function(i, block) {
    hljs.highlightBlock(block);
  });
});