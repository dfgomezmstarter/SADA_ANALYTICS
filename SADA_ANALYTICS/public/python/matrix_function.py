import numpy as np

np.set_printoptions(precision=7)


def determinant(matrix):
    if(np.linalg.det(matrix)!=0):
        return True
    else:
        return False

def mix_matrix(a,b):
    try:
        split_a = a.split('],[')
        vector = b.replace('[', '').replace(']', '').split(',')
        final_vector = []
        matrix_values = ""
        try:
            for row in range(len(split_a)):
                if (row == 0):
                    split_a[row] = split_a[row][2:] + ';'
                elif (row == len(split_a) - 1):
                    split_a[row] = split_a[row][:-2]
                else:
                    split_a[row] = split_a[row] + ';'
                matrix_values = matrix_values + str(split_a[row])
                final_vector.append(vector[row])
            a = np.matrix(matrix_values, dtype=float)
            b = np.matrix(vector, dtype=float)
            matrix = np.insert(a, a.shape[1], b, axis=1)
            return a, b, matrix
        except:
            print("Be careful about dimensions from matrix and the vector")
    except:
        print("Doesn't possible transform matrix to numeric matrix take a look in the matrix's values")
        exit(1)

def soltion(a,b):
    correction = []
    b = b.tolist()
    b = np.array(b)
    if (str(b.tolist())[0:2] == '[['):
        b = str(b.tolist())[2:-2]
        array = b.split(",")
        for value in array:
            correction.append(float(value))
        b = correction
        correction = []
    x = np.linalg.inv(a).dot(b)
    x = x.tolist()
    x = np.array(x)
    if (str(x.tolist())[0:2] == '[['):
        x = str(x.tolist())[2:-2]
        array = x.split(",")
        for value in array:
            correction.append(float(value))
        x= correction
        correction = []
    final_value = np.array([],dtype=str)
    for result in x:
        final_value = np.append(final_value, '{:.7f}'.format(result))
    return final_value

def sort(x,movement):
    movement = movement.astype(int)
    for i in range(len(movement)-1,0,-2):
        temporal_value = x[movement[i]]
        x[movement[i]] = x[movement[i-1]]
        x[movement[i-1]] = temporal_value
    return x


def rebuild_matrix(dic):
    final_row = np.array([],dtype=str)
    final_value = np.array([],dtype=str)
    for key in dic:
        matrix = dic[key]
        for row in matrix:
            for result in row.tolist():
                final_value = np.append(final_value, '{:.7f}'.format(result))
            final_row = np.append(final_row, str(final_value))
            final_value = np.array([], dtype=str)
        dic[key] = final_row.tolist()
        final_row = np.array([])
    return dic

def extract_D_L_U(A):
    # get the upper triangular part of this matrix
    u_values = -1*A[np.triu_indices(A.shape[0], k=1)]  #values for upper triangular matrix
    l_values = -1*A[np.tril_indices(A.shape[0], k=-1)] #values for lower triangular matrix

    # put it back into a 2D symmetric array
    U = np.zeros((A.shape[0], A.shape[0]))
    L = np.zeros((A.shape[0], A.shape[0]))

    #rebuild matrix 2D
    U[np.triu_indices(U.shape[0], k=1)] = u_values
    L[np.tril_indices(L.shape[0], k=-1)] = l_values
    D = np.diag(np.diag(A))
    return D,L,U