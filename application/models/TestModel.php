<?php
class TestModel extends MY_Model
{
	protected $_tableName = 'post';
	public function create() {
		$titleString = $this->randCc(4,10);
		$contentString = $this->randCc(100,200,rand(100,200));
		$createTime = $this->createTime(1466800000,1467000000);
		$updateTime = $this->updateTime(1466800000,1467000000);
		$authorId = $this->authorId(1,7);
		$tags = $this->randTags(rand(1,4));
		$data = array();
		$data['title'] = $titleString;
		$data['content'] = $contentString;
		$data['create_time'] = $createTime;
		$data['update_time'] = $updateTime;
		$data['author_id'] = $authorId;
		$data['status'] = rand(1,3);
		$data['tags'] = $tags;
		// var_dump($data);die();
		$this->db->insert($this->_tableName, $data);
		return $data['id'] = $this->db->insert_id();
	}

	//从数据库随机生成utf8字符串
	private function randCjk($min, $max) {
		$titleTotal = rand($min, $max);
		$titleNum = array();
		$titleString = '';
		for ($i=0; $i < $titleTotal; $i++) { 
			$titleNum[$i] = rand(1, 6763);
		}
		$this->db->select('cjk');
		$this->db->where_in('id', $titleNum);
		$unicode = $this->db->get('ci_gb2312');
		foreach ($unicode->result() as $value) {
			$titleString .= '&#x'.$value->cjk.';';
		}
		$titleString = html_entity_decode($titleString);
		return $titleString;
	}

	//随机生成unix时间戳的创建时间
	private function createTime($min, $max) {
		$createTime = rand($min, $max);
		return $createTime;
	}

	//随机生成unix时间戳的更新时间
	private function updateTime($min, $max) {
		$updateTime = rand($min, $max);
		return $updateTime;
	}

	//随机生成作者id
	private function authorId($min, $max) {
		$authorId = rand($min, $max);
		return $authorId;
	}

	private function randPun($contentTotal, $perPun) {
		$punctuation = array("ff0c","3002","ff1f","3001");
		$randNum = $contentTotal / $perPun;
		$punNum = array();
		for ($i=0; $i < $randNum; $i++) { 
			$punNum[$i] = $punctuation[array_rand($punctuation)];
		}
		return $punNum;
	}

	private function randTags($rand) {
		$tagsArray = array("PHP","Composer","教程","安装","查询构建器","模型","Laravel","CI3","Controller","Linux","数组","字符串","转换");
		$tagsNum = array_rand($tagsArray, $rand);
		$tags = '';
		if ($rand == 1) {
			$tags = $tagsArray[$tagsNum];
		} else {
			for ($i=0; $i < $rand; $i++) { 
				$tags .= $tagsArray[$tagsNum[$i]].',';
			}
			$tags = rtrim($tags, ',');
		}
		return $tags;
	}

	private function randCc($min, $max, $pun = null, $perPun = 10) {
		$character = array(
		 		"7684","4e00","662f","4e86","6211","4e0d","4eba","5728","4ed6","6709","8fd9","4e2a","4e0a","4eec","6765",
				"5230","65f6","5927","5730","4e3a","5b50","4e2d","4f60","8bf4","751f","56fd","5e74","7740","5c31","90a3",
				"548c","8981","5979","51fa","4e5f","5f97","91cc","540e","81ea","4ee5","4f1a","5bb6","53ef","4e0b","800c",
				"8fc7","5929","53bb","80fd","5bf9","5c0f","591a","7136","4e8e","5fc3","5b66","4e48","4e4b","90fd","597d",
				"770b","8d77","53d1","5f53","6ca1","6210","53ea","5982","4e8b","628a","8fd8","7528","7b2c","6837","9053",
				"60f3","4f5c","79cd","5f00","7f8e","603b","4ece","65e0","60c5","5df1","9762","6700","5973","4f46","73b0",
				"524d","4e9b","6240","540c","65e5","624b","53c8","884c","610f","52a8","65b9","671f","5b83","5934","7ecf",
				"957f","513f","56de","4f4d","5206","7231","8001","56e0","5f88","7ed9","540d","6cd5","95f4","65af","77e5",
				"4e16","4ec0","4e24","6b21","4f7f","8eab","8005","88ab","9ad8","5df2","4eb2","5176","8fdb","6b64","8bdd",
				"5e38","4e0e","6d3b","6b63","611f","89c1","660e","95ee","529b","7406","5c14","70b9","6587","51e0","5b9a",
				"672c","516c","7279","505a","5916","5b69","76f8","897f","679c","8d70","5c06","6708","5341","5b9e","5411",
				"58f0","8f66","5168","4fe1","91cd","4e09","673a","5de5","7269","6c14","6bcf","5e76","522b","771f","6253",
				"592a","65b0","6bd4","624d","4fbf","592b","518d","4e66","90e8","6c34","50cf","773c","7b49","4f53","5374",
				"52a0","7535","4e3b","754c","95e8","5229","6d77","53d7","542c","8868","5fb7","5c11","514b","4ee3","5458",
				"8bb8","7a1c","5148","53e3","7531","6b7b","5b89","5199","6027","9a6c","5149","767d","6216","4f4f","96be",
				"671b","6559","547d","82b1","7ed3","4e50","8272","66f4","62c9","4e1c","795e","8bb0","5904","8ba9","6bcd",
				"7236","5e94","76f4","5b57","573a","5e73","62a5","53cb","5173","653e","81f3","5f20","8ba4","63a5","544a",
				"5165","7b11","5185","82f1","519b","5019","6c11","5c81","5f80","4f55","5ea6","5c71","89c9","8def","5e26",
				"4e07","7537","8fb9","98ce","89e3","53eb","4efb","91d1","5feb","539f","5403","5988","53d8","901a","5e08",
				"7acb","8c61","6570","56db","5931","6ee1","6218","8fdc","683c","58eb","97f3","8f7b","76ee","6761","5462",
				"75c5","59cb","8fbe","6df1","5b8c","4eca","63d0","6c42","6e05","738b","5316","7a7a","4e1a","601d","5207",
				"600e","975e","627e","7247","7f57","94b1","7d36","5417","8bed","5143","559c","66fe","79bb","98de","79d1",
				"8a00","5e72","6d41","6b22","7ea6","5404","5373","6307","5408","53cd","9898","5fc5","8be5","8bba","4ea4",
				"7ec8","6797","8bf7","533b","665a","5236","7403","51b3","7aa2","4f20","753b","4fdd","8bfb","8fd0","53ca",
				"5219","623f","65e9","9662","91cf","82e6","706b","5e03","54c1","8fd1","5750","4ea7","7b54","661f","7cbe",
				"89c6","4e94","8fde","53f8","5df4","5947","7ba1","7c7b","672a","670b","4e14","5a5a","53f0","591c","9752",
				"5317","961f","4e45","4e4e","8d8a","89c2","843d","5c3d","5f62","5f71","7ea2","7238","767e","4ee4","5468",
				"5427","8bc6","6b65","5e0c","4e9a","672f","7559","5e02","534a","70ed","9001","5174","9020","8c08","5bb9",
				"6781","968f","6f14","6536","9996","6839","8bb2","6574","5f0f","53d6","7167","529e","5f3a","77f3","53e4",
				"534e","8ae3","62ff","8ba1","60a8","88c5","4f3c","8db3","53cc","59bb","5c3c","8f6c","8bc9","7c73","79f0",
				"4e3d","5ba2","5357","9886","8282","8863","7ad9","9ed1","523b","7edf","65ad","798f","57ce","6545","5386",
				"60ca","8138","9009","5305","7d27","4e89","53e6","5efa","7ef4","7edd","6811","7cfb","4f24","793a","613f",
				"6301","5343","53f2","8c01","51c6","8054","5987","7eaa","57fa","4e70","5fd7","9759","963f","8bd7","72ec",
				"590d","75db","6d88","793e","7b97","4e49","7adf","786e","9152","9700","5355","6cbb","5361","5e78","5170",
				"5ff5","4e3e","4ec5","949f","6015","5171","6bdb","53e5","606f","529f","5b98","5f85","7a76","8ddf","7a7f",
				"5ba4","6613","6e38","7a0b","53f7","5c45","8003","7a81","76ae","54ea","8d39","5012","4ef7","56fe","5177",
				"521a","8111","6c38","6b4c","54cd","5546","793c","7ec6","4e13","9ec4","5757","811a","5473","7075","6539",
				"636e","822c","7834","5f15","98df","4ecd","5b58","4f17","6ce8","7b14","751a","67d0","6c89","8840","5907",
				"4e60","6821","9ed8","52a1","571f","5fae","5a18","987b","8bd5","6000","6599","8c03","5e7f","8716","82cf",
				"663e","8d5b","67e5","5bc6","8bae","5e95","5217","5bcc","68a6","9519","5ea7","53c2","516b","9664","8dd1",
				"4eae","5047","5370","8bbe","7ebf","6e29","867d","6389","4eac","521d","517b","9999","505c","9645","81f4",
				"9633","7eb8","674e","7eb3","9a8c","52a9","6fc0","591f","4e25","8bc1","5e1d","996d","5fd8","8da3","652f",
				"6625","96c6","4e08","6728","7814","73ed","666e","5bfc","987f","7761","5c55","8df3","83b7","827a","516d",
				"6ce2","5bdf","7fa4","7687","6bb5","6025","5ead","521b","533a","5965","5668","8c22","5f1f","5e97","5426",
				"5bb3","8349","6392","80cc","6b62","7ec4","5dde","671d","5c01","775b","677f","89d2","51b5","66f2","9986",
				"80b2","5fd9","8d28","6cb3","7eed","54e5","547c","82e5","63a8","5883","9047","96e8","6807","59d0","5145",
				"56f4","6848","4f26","62a4","51b7","8b66","8d1d","8457","96ea","7d22","5267","554a","8239","9669","70df",
				"4f9d","6597","503c","5e2e","6c49","6162","4f5b","80af","95fb","5531","6c99","5c40","4f2f","65cf","4f4e",
				"73a9","8d44","5c4b","51fb","901f","987e","6cea","6d32","56e2","5723","65c1","5802","5175","4e03","9732",
				"56ed","725b","54ed","65c5","8857","52b3","578b","70c8","59d1","9648","83ab","9c7c","5f02","62b1","5b9d",
				"6743","9c81","7b80","6001","7ea7","7968","602a","5bfb","6740","5f8b","80dc","4efd","6c7d","53f3","6d0b",
				"8303","5e8a","821e","79d8","5348","767b","697c","8d35","5438","8d23","4f8b","8ffd","8f83","804c","5c5e",
				"6e10","5de6","5f55","4e1d","7259","515a","7ee7","6258","8d76","7ae0","667a","51b2","53f6","80e1","5409",
				"5356","575a","559d","8089","9057","6551","4fee","677e","4e34","85cf","62c5","620f","5584","536b","836f",
				"60b2","6562","9760","4f0a","6751","6234","8bcd","68ee","8033","5dee","77ed","7956","4e91","89c4","7a97",
				"6563","8ff7","6cb9","65e7","9002","4e61","67b6","6069","6295","5f39","94c1","535a","96f7","5e9c","538b",
				"8d85","8d1f","52d2","6742","9192","6d17","91c7","6beb","5634","6bd5","4e5d","51b0","65e2","72b6","4e71",
				"666f","5e2d","73cd","7ae5","9876","6d3e","7d20","8131","519c","7591","7ec3","91ce","6309","72af","62cd",
				"5f81","574f","9aa8","4f59","627f","7f6e","81d3","5f69","706f","5de8","7434","514d","73af","59c6","6697",
				"6362","6280","7ffb","675f","589e","5fcd","9910","6d1b","585e","7f3a","5fc6","5224","6b27","5c42","4ed8",
				"9635","739b","6279","5c9b","9879","72d7","4f11","61c2","6b66","9769","826f","6076","604b","59d4","62e5",
				"5a1c","5999","63a2","5440","8425","9000","6447","5f04","684c","719f","8bfa","5ba3","94f6","52bf","5956",
				"5bab","5ffd","5957","5eb7","4f9b","4f18","8bfe","9e1f","558a","964d","590f","56f0","5218","7f6a","4ea1",
				"978b","5065","6a21","8d25","4f34","5b88","6325","9c9c","8d22","5b64","67aa","7981","6050","4f19","6770",
				"8ff9","59b9","85f8","904d","76d6","526f","5766","724c","6c5f","987a","79cb","8428","83dc","5212","6388",
				"5f52","6d6a","542c","51e1","9884","5976","96c4","5347","7883","7f16","5178","888b","83b1","542b","76db",
				"6d4e","8499","68cb","7aef","817f","62db","91ca","4ecb","70e7","8bef"
				);
		$titleTotal = rand($min, $max);
		$titleNum = array();
		$titleString = ''; 
		$characterKey = array_rand($character, $titleTotal);
		for ($i=0; $i < $titleTotal; $i++) { 
			$titleNum[$i] = $character[$characterKey[$i]];
		}
		if ($pun) {
			$punNum = $this->randPun($pun, $perPun);
			$titleNum = array_merge($titleNum, $punNum);
			shuffle($titleNum);
		}

		foreach ($titleNum as $value) {
			$titleString .= '&#x'.$value.';';
		}
		$titleString = html_entity_decode($titleString);
		return $titleString;
	}
}

















