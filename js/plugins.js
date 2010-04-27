if(Nehan){
  // here you can add hook for each tag like sax parser.
  Nehan.ParserHook.addTagHook("test", function(pageNo, isV, tagStr, tagAttr, tagName){
  });

  Nehan.ParserHook.addTagHook("/test", function(pageNo, isV, tagStr, tagAttr, tagName){
  });
};
