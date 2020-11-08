<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class PreparationBattleComponent extends Component
{
    public function determineAttackOrDeffence($battleCharacter, $enemyBattleCharacter) {
        $dex1 = $battleCharacter->dexterity;
        $dex2 = $enemyBattleCharacter->dexterity;
        if ($dex1 > $dex2) {
            return [$battleCharacter, $enemyBattleCharacter];
        }
        if ($dex2 > $dex1) {
            return [$enemyBattleCharacter, $battleCharacter];
        }
        $d = rand(1, 2);
        if ($d === 1) {
            return [$battleCharacter, $enemyBattleCharacter];
        } else {
            return [$enemyBattleCharacter, $battleCharacter];
        }
    }

    public function validate($request, $flash) {
        $enemyChatCharacterKey = $request->getData('enemy_chat_character_key');
        if (!$enemyChatCharacterKey) {
            $flash->error(__('Choose an enemy.'));
            return 0;
        }
        $skills = [];
        $skills[] = $request->getData('battle_skill1_code');
        $skills[] = $request->getData('battle_skill2_code');
        $skills[] = $request->getData('battle_skill3_code');
        $skills[] = $request->getData('battle_skill4_code');
        $skills[] = $request->getData('battle_skill5_code');
        $skills[] = $request->getData('battle_skill6_code');
        $skills[] = $request->getData('battle_skill7_code');
        $skills = array_unique($skills);
        if (count($skills) != 7) {
            $flash->error(__('The skills are overlapping.'));
            return 0;
        }

        return 1;
    }

    public function organizeSkills($battleSaveSkill) {
        $skillCodes = [];
        $skillCodes[] = $battleSaveSkill->battle_skill1_code;
        $skillCodes[] = $battleSaveSkill->battle_skill2_code;
        $skillCodes[] = $battleSaveSkill->battle_skill3_code;
        $skillCodes[] = $battleSaveSkill->battle_skill4_code;
        $skillCodes[] = $battleSaveSkill->battle_skill5_code;
        $skillCodes[] = $battleSaveSkill->battle_skill6_code;
        $skillCodes[] = $battleSaveSkill->battle_skill7_code;
        sort($skillCodes);
        return $skillCodes;
    }

    public function organizeAttackSkills($battleSaveSkill, $battleSkills) {
        $skillCodes = $this->organizeSkills($battleSaveSkill);
        $result = [BT_AT_NASHI => '無し'];
        $bts = $battleSkills['攻撃スキル'] + $battleSkills['特殊スキル'];
        foreach ($skillCodes as $skillCode) {
            if (isset($bts[$skillCode])) {
                $result[$skillCode] = $bts[$skillCode];
            }
        }
        return $result;
    }

    public function organizeDefenseSkills($battleSaveSkill, $battleSkills) {
        $skillCodes = $this->organizeSkills($battleSaveSkill);
        $result = [BT_AT_NASHI => '無し'];
        $bts = $battleSkills['防御スキル'];
        foreach ($skillCodes as $skillCode) {
            if (isset($bts[$skillCode])) {
                $result[$skillCode] = $bts[$skillCode];
            }
        }
        return $result;
    }

    public function vsBeforeKey($key1, $key2) {
        $key1 = ($key1) ? $key1 : 0;
        $key2 = ($key2) ? $key2 : 0;
        return ($key1 < $key2) ? $key1 : $key2;
    }

    public function vsAfterKey($key1, $key2) {
        $key1 = ($key1) ? $key1 : 0;
        $key2 = ($key2) ? $key2 : 0;
        return ($key1 > $key2) ? $key1 : $key2;
    }

    public function preparationBattleCharacters(
        $battleCharacter, $battleTurn, $battleSaveSkill, $battleCharacterStatus
    ) {
        $battleCharacter->set('battle_turn_id', $battleTurn->id);

        $battleCharacter->set('chat_character_id', $battleCharacterStatus->chat_character_id);
        $battleCharacter->set('strength', $battleCharacterStatus->strength);
        $battleCharacter->set('dexterity', $battleCharacterStatus->dexterity);
        $battleCharacter->set('stamina', $battleCharacterStatus->stamina);
        $battleCharacter->set('spirit', $battleCharacterStatus->spirit);

        // HP: 40+stamina×4
        $hp = (40 + $battleCharacterStatus->stamina * 4);
        $battleCharacter->set('hp', $hp);

        // SP: 4+spirit×2
        $sp = (4 + $battleCharacterStatus->spirit * 2);
        if ($battleSaveSkill->passive_skill_code == BT_PAV_SP) {
            $sp += 3;
        }
        $battleCharacter->set('sp', $sp);

        // コンボ
        $combo = 0;
        if ($battleSaveSkill->passive_skill_code == BT_PAV_KONBO) {
            $combo += 2;
        }
        $battleCharacter->set('combo', $combo);

        $battleCharacter->set('limit_skill_code', $battleSaveSkill->limit_skill_code);

        $permanent_strength = 0;
        if ($battleSaveSkill->passive_skill_code == BT_PAV_KOU) {
            $permanent_strength += 1;
        }
        $battleCharacter->set('permanent_strength', $permanent_strength);

        $permanent_hit_rate = 0;
        if ($battleSaveSkill->passive_skill_code == BT_PAV_MEI) {
            $permanent_hit_rate += 10;
        }
        $battleCharacter->set('permanent_hit_rate', $permanent_hit_rate);

        $temporary_dodge_rate = 0;
        $battleCharacter->set('temporary_dodge_rate', $temporary_dodge_rate);

        return $battleCharacter;
    }
}
