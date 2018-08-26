var cx, cy
var clockRadius
var hourRadius
var minuteRadius
var secondRadius

function setup () {
  var canvas = createCanvas(350, 350)
  canvas.parent('my-analog-clock-container')

  clockRadius = width * 0.8 / 2
  hourRadius = clockRadius * 0.5
  minuteRadius = clockRadius * 0.75
  secondRadius = clockRadius * 0.9

  cx = width / 2
  cy = height / 2
}

function draw () {

  /* Draw the clock face */
  strokeWeight(5)
  stroke(0)
  ellipse(cx, cy, clockRadius * 2 - 5)

  strokeWeight(5)
  stroke(0)

  /* Get the current hour and normalize */
  var h = hour()
  if (h > 12) {
    h = h - 12
  }

  var m = minute()
  var s = second()

  /* Draw the hour */
  var hourXY = getXY(h, hourRadius, 6 * 5)
  line(cx, cy, hourXY[0], hourXY[1])

  /* Draw the minute */
  var minuteXY = getXY(m, minuteRadius)
  strokeWeight(2)
  line(cx, cy, minuteXY[0], minuteXY[1])

  /* Draw the second */
  var secondXY = getXY(s, minuteRadius)
  strokeWeight(1)
  line(cx, cy, secondXY[0], secondXY[1])
}

function getXY (time, radius, degrees = 6) {
  return [
    cos(radians(time * degrees - 90)) * radius + cx,
    sin(radians(time * degrees - 90)) * radius + cy
  ]
}