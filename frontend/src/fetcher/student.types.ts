import z from "zod";

export type Student = z.infer<typeof StudentSchema>;
export const StudentSchema = z.object({
  id: z.number(),
  name: z.string(),
  email: z.string().email(),
  grade: z.number(),
  birthday: z.string().pipe(z.coerce.date()),
});

export type Students = z.infer<typeof StudentsSchema>;
export const StudentsSchema = z.array(StudentSchema);

export type StudentRequestDto = Omit<Omit<Student, "id">, "birthday"> & { birthday: string };
export type StudentDeleteDto = Pick<Student, "id">;
export type StudentPUpdateDto = Partial<StudentRequestDto>;
