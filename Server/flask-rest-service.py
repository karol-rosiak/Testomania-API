import os
from flask import Flask, jsonify, abort, request, make_response, Response
from flask_cors import CORS
from flask_jsonschema import JsonSchema, ValidationError
from flasgger import Swagger,swag_from
import database as db

app = Flask(__name__, static_url_path="")

#swagger documentation
app.config['SWAGGER'] = {
    'title': 'Testomania API',
    'description': 'API for a quiz site'
}
swagger = Swagger(app)



#json schema validation
app.config['JSONSCHEMA_DIR'] = os.path.join(app.root_path, 'schemas')
jsonschema = JsonSchema(app)

#allow for connections from other domains
CORS(app)

@app.errorhandler(ValidationError)
def on_validation_error(e):
    return  make_response(jsonify({'error': 'Bad request'}),400)

@app.errorhandler(400)
def bad_request(error):
    return make_response(jsonify({'error': 'Bad request'}),400)


@app.errorhandler(404)
def not_found(error):
    return make_response(jsonify({'error': 'Not found'}),400)

#=============questions==============


@app.route('/questions', methods=['GET'])
@swag_from('yaml/questions.yml')
def get_questions():

    questions_list = db.get_questions()
    if (len(questions_list) == 0):
        return make_response(jsonify({'error': 'There are no questions in the database!'}), 404)
    else:
        return make_response(jsonify(questions_list), 200)


@app.route('/questions/random/<int:number>', methods=['GET'])
@swag_from('yaml/questions_random.yml')
def get_questions_random(number):
    questions_list = db.get_questions_random(number)
    if (len(questions_list) == 0):
        return make_response(jsonify({'error': 'There are no questions in the database!'}), 404)
    else:
        return make_response(jsonify(questions_list), 200)

@app.route('/questions/one', methods=['GET'])
@swag_from('yaml/questions_one.yml')
def get_one_question():
    question = db.get_one_question()
    if (len(question) == 0):
        return make_response(jsonify({'error': 'There are no questions in the database!'}), 404)
    else:
        return make_response(jsonify(question), 200)


@app.route('/questions/one/<int:question_id>', methods=['GET'])
@swag_from('yaml/questions_one_by_id.yml')
def get_one_question_by_id(question_id):
    question = db.get_one_question_by_id(question_id)
    if (len(question) == 0):
        return make_response(jsonify({'error': 'Wrong id of question!'}), 404)
    else:
        return make_response(jsonify(question), 200)


@app.route('/questions/add', methods=['POST'])
@jsonschema.validate('questions', 'insert')
@swag_from('yaml/questions_insert.yml')
def insert_question():
    if not request.json:
        abort(400)
    category_id = db.get_category_id(request.json["Category"])
    if(category_id == 0):
        return make_response(jsonify({'error': "couldn't find given category"}), 404)

    user_id = db.get_user_id(request.json["User"])
    if(user_id == 0):
        return make_response(jsonify({'error': "couldn't find given user"}), 404)

    rows_affected = db.insert_question(request.json,category_id,user_id)
    if rows_affected:
        return make_response(jsonify({'result': "ok"}), 201)
    else:
        return make_response(jsonify({'error': "couldn't insert question"}), 400)


@app.route('/questions/one/<int:question_id>/delete', methods=['DELETE'])
@swag_from('yaml/questions_delete.yml')
def delete_question(question_id):
    rows_affected = db.delete_question(question_id)
    if rows_affected:
        return make_response('', 204)
    else:
        return make_response(jsonify({'error': "couldn't delete question"}), 404)


@jsonschema.validate('questions', 'update')
@app.route('/questions/one/<int:question_id>/update', methods=['PUT'])
@swag_from('yaml/questions_update.yml')
def update_question(question_id):
    if not request.json or 'Question' not in request.json:
        abort(400)
    category_id = db.get_category_id(request.json["Category"])
    if (category_id == 0):
        return make_response(jsonify({'error': 'Wrong category given!'}), 404)
    rows_affected = db.update_question(question_id,request.json,category_id)
    if(rows_affected):
        return make_response(jsonify({'result': "ok"}), 200)
    else:
        return make_response(jsonify({'error': "Couldn't update question!"}), 404)


#=================categories=====================


@app.route('/categories', methods=['GET'])
@swag_from('yaml/categories.yml')
def get_categories():
    categories_list = db.get_categories()
    if (len(categories_list) == 0):
        return make_response(jsonify({'error': 'There are no categories in the database!'}), 404)
    else:
        return make_response(jsonify(categories_list),200)


@app.route('/categories/<int:category_id>', methods=['GET'])
@swag_from('yaml/categories_by_id.yml')
def get_one_category_by_id(category_id):
    category = db.get_one_category_by_id(category_id)
    if (len(category) == 0):
        return make_response(jsonify({'error': 'There are no category with given id!'}), 404)
    else:
        return make_response(jsonify(category),200)


@app.route('/categories/add', methods=['POST'])
@jsonschema.validate('categories', 'insert')
@swag_from('yaml/categories_insert.yml')
def insert_categories():
    if not request.json or 'Category' not in request.json:
        abort(400)

    rows_affected = db.insert_category(request.json)
    if rows_affected:
        return make_response(jsonify({'result': "ok"}), 201)
    else:
        return make_response(jsonify({'error': "couldn't insert category"}),400)


@app.route('/categories/<int:category_id>/delete', methods=['DELETE'])
@swag_from('yaml/categories_delete.yml')
def delete_category(category_id):
    rows_affected = db.delete_category(category_id)
    if(rows_affected):
        return make_response('', 204)
    else:
        make_response(jsonify({'error': "couldn't delete category"}), 404)



@app.route('/categories/<int:category_id>/update', methods=['PUT'])
@jsonschema.validate('categories', 'update')
@swag_from('yaml/categories_update.yml')
def update_category(category_id):
    if not request.json or 'Category' not in request.json:
        abort(400)

    rows_affected = db.update_category(category_id, request.json)
    if(rows_affected):
        return make_response(jsonify({'result': "ok"}), 200)
    else:
        make_response(jsonify({'error': "couldn't update category"}), 404)
#===================stats======================


@app.route('/stats', methods=['GET'])
@swag_from('yaml/stats.yml')
def get_stats():
    statsList = db.get_stats()
    if (len(statsList) == 0):
        return make_response(jsonify({'error': 'There are no stats of users in the database!'}), 404)
    else:
        return make_response(jsonify(statsList),200)


@app.route('/stats/ranking/<string:sort_by>/<string:sort_type>', methods=['GET'])
@swag_from('yaml/stats_ranking.yml')
def get_stats_sorted(sort_by,sort_type):
    statsList = db.get_stats_sorted(sort_by,sort_type)

    if (len(statsList) == 0):
        return make_response(jsonify({'error': 'There are no stats of users in the database!'}), 404)
    else:
        return make_response(jsonify(statsList),200)


@app.route('/stats/id/<int:user_id>', methods=['GET'])
@swag_from('yaml/stats_by_id.yml')
def get_stats_by_id(user_id):
    stats = db.get_stats_by_id(user_id)
    if(len(stats) == 0):
        return make_response(jsonify({'error': 'Invalid user id'}), 404)
    else:
        return make_response(jsonify(stats),200)


@app.route('/stats/name/<string:user_login>', methods=['GET'])
@swag_from('yaml/stats_by_name.yml')
def get_stats_by_name(user_login):
    stats = db.get_stats_by_name(user_login)
    if(len(stats) == 0):
        return make_response(jsonify({'error': 'Invalid user login'}), 404)
    else:
        return make_response(jsonify(stats),200)


@app.route('/stats/add', methods=['PUT'])
@jsonschema.validate('stats', 'add')
@swag_from('yaml/stats_add.yml')
def add_points():
    if not request.json or 'Points' not in request.json:
        abort(400)
    user_id = db.get_user_id(request.json["Login"])
    if(user_id==0):
        return make_response(jsonify({'error': "This user doesn't exist!"}), 400)

    rows_affected = db.add_points(request.json, user_id)
    if rows_affected:
        return make_response(jsonify({'result': "ok"}), 200)
    else:
        return make_response(jsonify({'error': "couldn't add points"}), 404)


@app.route('/stats/<int:user_id>/clear', methods=['PUT'])
@swag_from('yaml/stats_clear.yml')
def clear_points(user_id):
    rows_affected = db.clear_stats(user_id)
    if rows_affected:
        return make_response(jsonify({'result': "ok"}), 200)
    else:
        return make_response(jsonify({'error': "couldn't clear points"}), 404)

#====================users==========================


@app.route('/users', methods=['GET'])
@swag_from('yaml/users.yml')
def get_users():
    users = db.get_users()
    if (len(users) == 0):
        return make_response(jsonify({'error': 'There are no users in the database!'}), 404)
    else:
        return make_response(jsonify(users), 200)


@app.route('/users/id/<int:user_id>', methods=['GET'])
@swag_from('yaml/users_by_id.yml')
def get_user_by_id(user_id):
    user = db.get_user_by_id(user_id)
    if(len(user) == 0):
        return make_response(jsonify({'error': 'Invalid user ID'}), 404)
    else:
        return make_response(jsonify(user), 200)


@app.route('/users/name/<string:user_login>', methods=['GET'])
@swag_from('yaml/users_by_name.yml')
def get_user_by_name(user_login):
    user = db.get_user_by_login(user_login)

    if(len(user) == 0):
        return make_response(jsonify({'error': 'Invalid user Login'}), 404)
    else:
        return make_response(jsonify(user), 200)


@app.route('/users/add', methods=['POST'])
@jsonschema.validate('users', 'register')
@swag_from('yaml/users_insert.yml')
def insert_user():
    if not request.json or 'Login' not in request.json:
        abort(400)

    if(db.check_login(request.json)>0):
        return make_response(jsonify({'error': "User with the same login exists!"}), 400)

    if(db.check_email(request.json)>0):
        return make_response(jsonify({'error': "User with the same email exists!"}), 400)

    rows_affected = db.insert_user(request.json)

    if rows_affected:
        return make_response(jsonify({'result': "ok"}), 201)
    else:
        return  make_response(jsonify({'error': "couldn't insert user"}),400)


@app.route('/users/<int:user_id>/delete', methods=['DELETE'])
@swag_from('yaml/users_delete.yml')
def delete_user(user_id):
    rows_affected = db.delete_user(user_id)
    if(rows_affected):
        return make_response('', 204)
    else:
        make_response(jsonify({'error': "couldn't delete user"}), 404)



@app.route('/users/<int:user_id>/update', methods=['PUT'])
@jsonschema.validate('users', 'update')
@swag_from('yaml/users_update.yml')
def update_user(user_id):
    if not request.json or 'ID' not in request.json:
        abort(400)
    rows_affected = db.update_user(user_id, request.json)
    if rows_affected:
        return make_response(jsonify({'result': "ok"}), 200)
    else:
        return  make_response(jsonify({'error': "couldn't update user"}),400)



@app.route('/users/<int:user_id>/password', methods=['PUT'])
@jsonschema.validate('users', 'password')
@swag_from('yaml/users_update_password.yml')
def update_user_password(user_id):
    if not request.json or 'Password' not in request.json:
        abort(400)
    rows_affected = db.update_user_password(user_id, request.json)
    if rows_affected:
        return make_response(jsonify({'result': "ok"}), 201)
    else:
        return  make_response(jsonify({'error': "couldn't update password"}),400)


@app.route('/users/<string:user_login>/login', methods=['GET'])
@swag_from('yaml/users_login.yml')
def login_user(user_login):
    return_data = db.login_user(user_login)
    if(len(return_data) == 0):
        return make_response(jsonify({'error': 'Invalid user name or password'}), 404)
    else:
         return make_response(jsonify(return_data), 200)


if __name__ == '__main__':
    app.run(host='127.0.0.1')
