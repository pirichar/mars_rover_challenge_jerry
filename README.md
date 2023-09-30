# Mission Mars

A squad of robotic rovers are to be landed by NASA on a plateau on Mars. This
plateau, which is curiously rectangular, must be navigated by the rovers so
that their cameras can get a complete view of the surrounding terrain to send
back to Earth.

A rover's position is represented by a combination of `x` and `y` coordinates,
and a letter representing one of the four cardinal compass points. The plateau
is divided up into a grid to simplify navigation. An example position might be
`0 0 N`, which means the rover is in the bottom left corner facing North.

In order to control a rover, NASA sends a simple string of letters. The
possible letters are `L`, `R` and `M`.

`L` and `R` make the rover spin 90 degrees left or right respectively, without
moving from its current position. `M` makes the rover move forward by 1 grid
point, and maintain the same direction.

Assume that the square directly North from `(x, y)` is `(x, y+ 1)`.

## Input

The first line of input is the upper-right coordinates of the plateau, the
lower-left coordinates are assumed to be `0, 0`.

The rest of the input is information pertaining to the rovers that have been
deployed. Each rover has two lines of input. The first line gives the rover's
initial position, and the second line is a series of instructions telling the
rover how to explore the plateau.

The position is made up of two integers and a letter separated by spaces,
corresponding to the `x` and `y` coordinates and the rover's orientation.

Each rover will be finished sequentially, which means that the second rover
won't start moving until the first one has finished.



## Usage : php index.php test.map