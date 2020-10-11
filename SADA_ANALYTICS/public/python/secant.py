import sympy as sm
import math
import sys
import traceback
import json
import base64
def secant(f_function, x0, x1, tolerance, iterations):
    results = {}
    try:
        f_function = str(f_function)
        x0 = float(x0)
        x1 = float(x1)
        tolerance = float(tolerance)
        iterations = int(iterations)
        if tolerance <= 0:
            raise Exception("Tolerance must be positive")
        elif iterations <= 0:
            raise Exception("The number of iterations must be greater than 0")
        else:
            iter_count = 0
            x_in = sm.symbols('x')
            f_x_0 = sm.sympify(f_function).subs(x_in, x0)
            f_x_1 = sm.sympify(f_function).subs(x_in, x1)
            error = float("inf")
            results[iter_count] = [int(iter_count), float(x0), float(f_x_0), "N/A"]
            iter_count += 1
            results[iter_count] = [int(iter_count), float(x1), float(f_x_1), "N/A"]
            previous_x = x1
            second_previous_x = x0
            while iter_count < iterations and error > tolerance:
                iter_count += 1
                first_term = previous_x
                f_previous_x = sm.sympify(f_function).subs(x_in, previous_x)
                second_term = f_previous_x*(previous_x - second_previous_x)
                f_second_previous_x = sm.sympify(f_function).subs(x_in, second_previous_x)
                second_term /= f_previous_x-f_second_previous_x
                current_x = first_term - second_term
                f_current_x = sm.sympify(f_function).subs(x_in, current_x)
                error = abs(current_x - previous_x)
                results[iter_count] = [int(iter_count), float(current_x), float(f_current_x), float(error)]
                second_previous_x = previous_x
                previous_x = current_x
            if error <= tolerance:
                iter_count += 1
                #results.append("Se encontró una aproximación de la raiz en {}".format(current_x))
            else:
                iter_count += 1
                #results.append("No se encontró una aproximación de la raiz. Último valor de x: {}".format(current_x))
    except BaseException as e:
        results[0] = "Error in the given data: " + str(e)
    aux = json.dumps(results)
    print(aux)
secant(sys.argv[1],sys.argv[2],sys.argv[3],sys.argv[4],sys.argv[5])