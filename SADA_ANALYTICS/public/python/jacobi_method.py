"""
Created on Wednesday Nov 11
Parameters
----------
d: vector with values for principal diagonal from matrix a
l: vector with values for lower triangular from matrix a
u: vector with values for upper triangular from matrix a
b: constant vector
x0: Initial vector aproximation
tol: Tolerance
Nmax: Maximum number of iterations
Returns
-------
dic: step dictionary (float with decimals)
dic_resoult: step dictionary from table solution (float with decimals)

@author: Daniel Felipe Gomez Martinez
"""
import numpy as np
import matrix_function
import json
import base64
np.set_printoptions(precision=7)

def jacobiMethod(l,d,u,b,x0,tol,Nmax):
    dic = {}
    dic_resoult= {}
    try:
        x0 = np.array(x0)
        T = np.dot(np.linalg.inv(d),(l + u))
        C = np.reshape(np.diag(np.multiply(np.linalg.inv(d),b)),(b.shape[1],1))
        E = float("inf")
        xant = np.reshape(x0,(x0.shape[0],1))
        cont = 0

        values, normalized_eigenvectors = np.linalg.eig(T)
        spectral_radius = max(abs(values))
        if spectral_radius > 1:
            dic = {}
            raise Exception("Error: Jacobi method does not work becuase its spectral radius is greater than 1")
            print(json.dumps(dic))
            exit(1)

        C_aux = C.T[0]

        dic["T"] = T
        dic_resoult[cont] = [0, '', str(matrix_function.rebuild_vector(x0))[1:-1].replace("'","").split()]


        while E>tol and cont<Nmax:
            xact = np.dot(T,xant) + C
            E =  np.linalg.norm(xant - xact)
            xant = xact
            cont = cont + 1
            aux = str(matrix_function.rebuild_vector(xant.T[0]))[1:-1].replace("'","").split()
            dic_resoult[cont] = [cont,round(float(E),7),aux]

        C_aux = str(matrix_function.rebuild_vector(C_aux))[1:-1].replace("'","").split()
        spectral_radius = matrix_function.rebuild_constant(spectral_radius)
    except BaseException as e:
        if("Error" in str(e)):
            dic[0]=str(e)
        else:
            dic[0] = "Error " + str(e)
        print(json.dumps(dic))
        exit(1)

    return dic,dic_resoult,C_aux,spectral_radius

