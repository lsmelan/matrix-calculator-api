# Matrix Calculator Rest API

##### A (3x4):

```
[
    [1,2,3,8],
    [4,5,6,9],
    [7,8,9,11]
]
```

##### B (4x3):

```
[
    [7,8,10],
    [9,10,12],
    [11,12,15],
    [13,14,18]
]
```

##### Result (3x3):

```
[
    {
        "A": 162,
        "B": 176,
        "C": 223
    },
    {
        "A": 256,
        "B": 280,
        "C": 352
    },
    {
        "A": 363,
        "B": 398,
        "C": 499
    }
]
```

### Matrices multiplication endpoint

For the result above the request should be like this (assuming you are running the API in local environment on the port 8080):

```
[GET] http://localhost:8080/matrices/multiplication?a=[[1,2,3,8],[4,5,6,9], [7,8,9,11]]&b=[[7,8,10],[9,10,12],[11,12,15], [13,14,18]]
```

The resulting matrix should be returned if the condition is met with the code 200, otherwise an error and the code 400 will be shown.

### The following cases are covered by unit tests:

Router
* Not defined route returns 404
* Get matrices multiplication returns 200
* Get matrices multiplication returns 400 with invalid args

MultiplicationController
* By matrix returns ok
* By matrix returns 400 with invalid args
* By matrix returns 400 with invalid matrix
* By matrix returns 400 with generic exception

MatrixCalculator
* Get current value returns empty if no value is set
* Get current value returns current value after setting it
* First moves cursor to first element
* Last moves cursor to last element
* Count rows returns zero if no value is set
* Count rows returns number of rows of the current value
* Count columns returns zero if no value is set
* Count columns returns number of columns of the current value
* Result returns empty array by default
* Calculate should return an object

MatrixExcel
* Convert returns empty array if input is empty array
* Convert returns empty array if some row is not array
* Convert converts given array index to its excel column with data set "With index 0 should return index A"
* Convert converts given array index to its excel column with data set "With index 1 should return index B"
* Convert converts given array index to its excel column with data set "With index 2 should return index C"
* Convert converts given array index to its excel column with data set "With index 3 should return index D"
* Convert converts given array index to its excel column with data set "With index 4 should return index E"
* Convert converts given array index to its excel column with data set "With index 5 should return index F"
* Convert converts given array index to its excel column with data set "With index 6 should return index G"
* Convert converts given array index to its excel column with data set "With index 7 should return index H"
* Convert converts given array index to its excel column with data set "With index 8 should return index I"
* Convert converts given array index to its excel column with data set "With index 9 should return index J"
* Convert converts given array index to its excel column with data set "With index 10 should return index K"
* Convert converts given array index to its excel column with data set "With index 25 should return index Z"
* Convert converts given array index to its excel column with data set "With index 26 should return index AA"
* Convert converts given array index to its excel column with data set "With index 27 should return index AB"
* Convert converts given array index to its excel column with data set "With multiple indexes should return their mapped columns"

MatrixMultiplication
* Calculate sets empty result if value is not set
* Calculate throws exception when matrices not valid
* Calculate multiplies given matrices with data set "With 2x3 and 3x2 returns 2x2"
* Calculate multiplies given matrices with data set "With 2x2 and 2x2 return 2x2"
* Calculate multiplies given matrices with data set "With 2x2 and 2x2 sets hidden column as 0 and returns 2x2"
* Calculate multiplies given matrices with data set "With 1x3 and 3x1 returns 1x1"
