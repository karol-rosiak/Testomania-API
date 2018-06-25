import mysql.connector


def execute_query(query, arguments=None, return_rows = True):
    cnx = mysql.connector.connect(user='root', database='sitedb')  # connect to database
    cursor = cnx.cursor(buffered=True, dictionary=True)  # get all data from database and take name of columns

    if (arguments == None):
        cursor.execute(query)
    else:
        cursor.execute(query, arguments)
    cnx.commit()
    if(return_rows == True):
        array = cursor.fetchall()
    else:
        row_count = cursor.rowcount

    cursor.close()
    cnx.close()

    return array if return_rows else row_count

#==============Questions==============


def get_questions():
    questionsList = execute_query("SELECT * FROM questions")
    return questionsList


def get_questions_random(number):
    query = "SELECT * FROM questions ORDER BY RAND() LIMIT %s"
    questionsList = execute_query(query, (number, ))
    return questionsList


def get_one_question():
    question = execute_query("SELECT * FROM questions ORDER BY rand() LIMIT 1")
    return question

def get_one_question_by_id_detailed(question_id):
    query = ("SELECT q.ID,q.A,q.B,q.C,q.D, c.Name,u.login FROM questions q"
             " INNER JOIN category c ON q.CategoryId = c.id"
             " INNER JOIN users u ON q.UserID = u.id"
             " WHERE q.ID = %s")

    question = execute_query(query, (question_id,))
    return question

def get_one_question_by_id(question_id):
    query = "SELECT * FROM questions WHERE id = %s"
    question = execute_query(query,(question_id,))
    return question


def insert_question(json,category_id,user_id):

    query = ("INSERT INTO questions VALUES(DEFAULT,%s,%s,%s,%s,%s,%s,%s,%s)")

    affected_rows = execute_query(query,
                  (json["Question"], json["A"], json["B"], json["C"],
                   json["D"], json["Correct"],category_id ,user_id ),False)

    return affected_rows


def delete_question(question_id):
    query = ("DELETE FROM questions WHERE id = %s")

    affected_rows = execute_query(query,
                  (question_id,),False)

    return affected_rows


def update_question(id,json,category_id):

    query = ("UPDATE questions SET Question = %s, A = %s, B = %s, C = %s, D = %s, Correct = %s, CategoryID = %s" 
             " WHERE id = %s")

    affected_rows = execute_query(query,
                  (json["Question"], json["A"], json["B"], json["C"],
                   json["D"], json["Correct"],category_id,id),False)

    return affected_rows


#=====================Categories=========================


def get_categories():
    categoryList = execute_query("SELECT * FROM categories")
    return categoryList


def get_one_category_by_id(category_id):
    query = "SELECT * FROM categories WHERE id = %s"
    category = execute_query(query,(category_id,))
    return category


def insert_category(json):
    query = ("INSERT INTO categories(Name) VALUES(%s)")

    affected_rows = execute_query(query,
                  (json["Category"],),False)
    print("Insert category affected rows:", affected_rows)
    return affected_rows


def delete_category(category_id):
    query = ("DELETE FROM questions WHERE CategoryId = %s")

    execute_query(query,(category_id,),False)

    query = ("DELETE FROM categories WHERE id = %s")

    affected_rows = execute_query(query,
                  (category_id,),False)

    print("Delete category affected rows:", affected_rows)
    return affected_rows


def update_category(category_id,json):
    query = ("UPDATE categories SET Name = %s WHERE id = %s")

    affected_rows = execute_query(query,
                  (json["Category"], category_id), False)
    print("Update category affected rows:", affected_rows)
    return affected_rows

def get_category_id(name):
    query = ("SELECT ID FROM categories WHERE Name = %s")

    return_value = execute_query(query, (name, ))
    id = return_value[0]["ID"]
    if(id>0):
        return id
    else:
        return 0

#======stats======


def get_stats():
    query = ("SELECT st.QuizzesCompleted AS Completed,st.PointsEarned AS Points, u.Login AS Login FROM `stats` st"
             " INNER JOIN users u ON st.UserId = u.ID")
    statsList = execute_query(query)
    return statsList


def get_stats_sorted(sort_by,sort_type):
    query = ("SELECT st.QuizzesCompleted AS Completed,st.PointsEarned AS Points, u.Login AS Login FROM `stats` st"
             " INNER JOIN users u ON st.UserId = u.ID"
             " ORDER BY " + sort_by + " " + sort_type) #not elegant way but couldn't get it to work otherwise
    statsList = execute_query(query)
    return statsList


def get_stats_by_id(user_id):
    query = ("SELECT st.QuizzesCompleted AS Completed,st.PointsEarned AS Points, u.Login AS Login FROM `stats` st"
             " INNER JOIN users u ON st.UserId = u.ID"
             " WHERE u.ID = %s")
    stats = execute_query(query,(user_id,))
    return stats


def get_stats_by_name(user_name):
    query = ("SELECT st.QuizzesCompleted AS Completed,st.PointsEarned AS Points, u.Login AS Login FROM `stats` st"
             " INNER JOIN users u ON st.UserId = u.ID"
             " WHERE u.Login = %s")
    stats = execute_query(query,(user_name,))
    return stats


def add_points(json, user_id):
    query = ("SELECT COUNT(*) AS Count FROM stats WHERE UserId=%s")

    exists = execute_query(query,(user_id,))
    if(exists[0]["Count"]>0):
        query = ("UPDATE stats SET QuizzesCompleted = QuizzesCompleted + 1, PointsEarned = PointsEarned + %s"
                 " WHERE UserId = %s")
        affected_rows = execute_query(query, (json["Points"], user_id), False)
    else:
        query = ("INSERT INTO stats(UserId, QuizzesCompleted, PointsEarned) VALUES(1, %s, %s)")
        affected_rows = execute_query(query, (user_id,json["Points"]), False)
    return affected_rows


def clear_stats(user_id):
    query = ("UPDATE stats SET QuizzesCompleted = 0, PointsEarned = 0 WHERE UserId = %s")
    affected_rows = execute_query(query,(user_id,), False)
    return affected_rows

#======================user====================
def get_users():
    user = execute_query("SELECT ID,Login,Email,Rank FROM users")
    return user

def get_user_by_id(user_id):
    query = "SELECT ID,Login,Email,Rank FROM users where id = %s"
    user = execute_query(query, (user_id,))
    return user

def get_user_by_login(user_login):
    query = "SELECT ID,Login,Email,Rank FROM users where Login = %s"
    user = execute_query(query, (user_login,))
    return user


def update_user(user_id, json):
    query = ("UPDATE users SET Login = %s,Email = %s WHERE id = %s")

    affected_rows = execute_query(query,
                  (json["Login"],json["Email"], user_id), False)
    print("Update user affected rows:", affected_rows)
    return affected_rows


def insert_user(json):
    query = ("INSERT INTO users(Login,Password,Email) VALUES (%s,%s,%s)")

    affected_rows = execute_query(query,
                  (json["Login"],json["Password"],json["Email"]), False)
    print("Insert user affected rows:", affected_rows)
    return affected_rows


def update_user_password(user_id, json):
    query = ("UPDATE users SET Password = %s WHERE id = %s")

    affected_rows = execute_query(query,
                  (json["Password"], user_id), False)
    print("Update user password affected rows:", affected_rows)
    return affected_rows


def delete_user(user_id):
    query = ("DELETE FROM questions WHERE UserId = %s")

    execute_query(query,(user_id,),False)

    query = ("DELETE FROM users WHERE id = %s")

    affected_rows = execute_query(query,
                  (user_id,),False)

    print("Delete user affected rows:", affected_rows)
    return affected_rows


def check_login(json):
    query = ("SELECT COUNT(*) AS Count FROM users WHERE Login=%s")

    login = execute_query(query,
                  (json["Login"], ))
    print("User with this login:", login[0]["Count"])
    return login[0]["Count"]


def login_user(user_login):
    query = "SELECT Id,Password,Rank FROM users WHERE login = %s"
    password_confirm = execute_query(query, (user_login, ))

    return password_confirm


def check_email(json):
    query = ("SELECT COUNT(*) AS Count FROM users WHERE Email=%s")

    email = execute_query(query,
                  (json["Email"], ))
    print("User with this email:", email[0]["Count"])
    return email[0]["Count"]


def get_user_id(name):
    query = ("SELECT ID FROM users WHERE Login = %s")

    return_value = execute_query(query, (name, ))
    if(len(return_value)<1):
        return 0
    user_id = return_value[0]["ID"]
    if(user_id>0):
        return user_id
    else:
        return 0
