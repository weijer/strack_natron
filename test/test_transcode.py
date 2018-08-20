reader = app.createReader("test.mov")
reader.setScriptName("StrackReader")
writerVideo = app.createWriter("test.mp4")

writerVideo.setScriptName("StrackWriterVideo")
writerVideo.getParam("formatType").setValue(0)
writerVideo.getParam("format").setValue(6)
writerVideo.getParam("codec").setValue(37)
writerVideo.getParam("fps").setValue(24)

writerVideo.connectInput(0,reader)

writerThumb = app.createWriter("test.####.jpg")

writerThumb.setScriptName("StrackWriterThumb")

writerThumb.getParam("formatType").setValue(0)
writerThumb.getParam("ocioOutputSpaceIndex").setValue(14)
writerThumb.getParam("frameRange").setValue(2)
writerThumb.getParam("firstFrame").setValue(1)
writerThumb.getParam("lastFrame").setValue(1)

writerThumb.connectInput(0,reader)
